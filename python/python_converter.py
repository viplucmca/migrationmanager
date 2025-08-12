from flask import Flask, request, jsonify, send_file
from docx import Document
from docx2txt import process
import io
import os
import tempfile
import zipfile
import xml.etree.ElementTree as ET
from reportlab.pdfgen import canvas
from reportlab.lib.pagesizes import letter
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import inch
import base64

app = Flask(__name__)

def extract_text_from_docx(docx_path):
    """Extract text from DOCX file"""
    try:
        # Try using python-docx2txt first
        text = process(docx_path)
        if text and text.strip():
            return text.strip()
    except:
        pass
    
    try:
        # Fallback to python-docx
        doc = Document(docx_path)
        text = []
        for paragraph in doc.paragraphs:
            if paragraph.text.strip():
                text.append(paragraph.text)
        return '\n'.join(text)
    except Exception as e:
        raise Exception(f"Failed to extract text from DOCX: {str(e)}")

def create_pdf_from_text(text, output_path):
    """Create PDF from extracted text"""
    try:
        doc = SimpleDocTemplate(output_path, pagesize=letter)
        styles = getSampleStyleSheet()
        story = []
        
        # Split text into paragraphs
        paragraphs = text.split('\n')
        
        for para_text in paragraphs:
            if para_text.strip():
                # Create paragraph with proper styling
                para = Paragraph(para_text, styles['Normal'])
                story.append(para)
                story.append(Spacer(1, 12))
        
        if story:
            doc.build(story)
            return True
        else:
            # Create empty PDF if no content
            c = canvas.Canvas(output_path, pagesize=letter)
            c.drawString(100, 750, "Empty document")
            c.save()
            return True
            
    except Exception as e:
        raise Exception(f"Failed to create PDF: {str(e)}")

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'python-docx-to-pdf-converter',
        'version': '1.0.0'
    })

@app.route('/convert-json', methods=['POST'])
def convert_docx_to_pdf():
    """Convert DOCX to PDF and return as JSON with base64 encoded PDF"""
    try:
        if 'file' not in request.files:
            return jsonify({'success': False, 'error': 'No file provided'}), 400
        
        file = request.files['file']
        if file.filename == '':
            return jsonify({'success': False, 'error': 'No file selected'}), 400
        
        # Validate file extension
        if not file.filename.lower().endswith(('.doc', '.docx')):
            return jsonify({'success': False, 'error': 'Invalid file format. Only .doc and .docx files are supported'}), 400
        
        # Create temporary files
        with tempfile.NamedTemporaryFile(delete=False, suffix='.docx') as temp_docx:
            file.save(temp_docx.name)
            docx_path = temp_docx.name
        
        with tempfile.NamedTemporaryFile(delete=False, suffix='.pdf') as temp_pdf:
            pdf_path = temp_pdf.name
        
        try:
            # Extract text from DOCX
            text = extract_text_from_docx(docx_path)
            
            # Create PDF from text
            create_pdf_from_text(text, pdf_path)
            
            # Read PDF and convert to base64
            with open(pdf_path, 'rb') as pdf_file:
                pdf_data = pdf_file.read()
                pdf_base64 = base64.b64encode(pdf_data).decode('utf-8')
            
            # Clean up temporary files
            os.unlink(docx_path)
            os.unlink(pdf_path)
            
            return jsonify({
                'success': True,
                'filename': file.filename,
                'method': 'python-docx-to-pdf',
                'message': 'Conversion completed successfully',
                'pdf_data': pdf_base64
            })
            
        except Exception as e:
            # Clean up temporary files on error
            if os.path.exists(docx_path):
                os.unlink(docx_path)
            if os.path.exists(pdf_path):
                os.unlink(pdf_path)
            raise e
            
    except Exception as e:
        return jsonify({
            'success': False,
            'error': f'Conversion failed: {str(e)}'
        }), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)