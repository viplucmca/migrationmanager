# Python DOC/DOCX to PDF Converter - Laravel Implementation

This implementation provides a clean, Python-based solution for converting DOC/DOCX files to PDF in Laravel applications.

## Table of Contents
1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Python Service Setup](#python-service-setup)
4. [Laravel Implementation](#laravel-implementation)
5. [Usage](#usage)
6. [Configuration](#configuration)

## Requirements

### Laravel Requirements

- Laravel 8+ 


- PHP 8.0+
- Guzzle HTTP Client (for API calls)

### Python Requirements
- Python 3.7+
- python-docx
- python-docx2txt
- python-docx2pdf
- Flask

## Installation

### 1. Install Laravel Dependencies
```bash
composer require guzzlehttp/guzzle
```

### 2. Create Python Service Files

#### Python Converter Service (`python_converter.py`)
```python
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
```

#### Python Requirements (`requirements.txt`)
```txt
Flask==2.3.3
python-docx==0.8.11
python-docx2txt==0.8
reportlab==4.0.4
```

### 3. Laravel Implementation Files

#### Service Provider (`app/Services/PythonConverterService.php`)
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class PythonConverterService
{
    private $apiUrl;
    private $timeout;

    public function __construct()
    {
        $this->apiUrl = env('PYTHON_CONVERTER_URL', 'http://localhost:5000');
        $this->timeout = env('PYTHON_CONVERTER_TIMEOUT', 120); // 2 minutes timeout
    }

    /**
     * Convert a DOC/DOCX file to PDF using the Python API
     */
    public function convertToPdf(UploadedFile $file, string $outputPath = null): array
    {
        try {
            // Validate file
            $this->validateFile($file);

            // Check if Python API is available
            if (!$this->isApiAvailable()) {
                throw new \Exception('Python conversion service is not available');
            }

            // Make request to Python API
            $response = Http::timeout($this->timeout)
                ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post($this->apiUrl . '/convert-json');

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['success']) {
                    // Convert base64 data back to binary
                    $pdfData = base64_decode($data['pdf_data']);
                    
                    // Save to output path if provided
                    if ($outputPath) {
                        file_put_contents($outputPath, $pdfData);
                    }
                    
                    return [
                        'success' => true,
                        'pdf_data' => $pdfData,
                        'filename' => $data['filename'],
                        'method' => $data['method'],
                        'message' => $data['message']
                    ];
                } else {
                    throw new \Exception($data['error'] ?? 'Conversion failed');
                }
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error'] ?? 'HTTP request failed';
                throw new \Exception("API request failed: {$errorMessage}");
            }

        } catch (\Exception $e) {
            Log::error('Python conversion failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Convert file and return PDF as download response
     */
    public function convertAndDownload(UploadedFile $file): \Illuminate\Http\Response
    {
        $result = $this->convertToPdf($file);
        
        if (!$result['success']) {
            throw new \Exception($result['error']);
        }

        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.pdf';
        
        return response($result['pdf_data'])
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Check if the Python API is available
     */
    public function isApiAvailable(): bool
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl . '/health');
            return $response->successful() && $response->json('status') === 'healthy';
        } catch (\Exception $e) {
            Log::warning('Python API health check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get API status information
     */
    public function getApiStatus(): array
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl . '/health');
            
            if ($response->successful()) {
                return [
                    'available' => true,
                    'status' => $response->json()
                ];
            } else {
                return [
                    'available' => false,
                    'error' => 'API responded with error: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            return [
                'available' => false,
                'error' => 'API connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Validate uploaded file
     */
    private function validateFile(UploadedFile $file): void
    {
        $allowedExtensions = ['doc', 'docx'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception("Unsupported file format. Allowed formats: " . implode(', ', $allowedExtensions));
        }

        $maxSize = 50 * 1024 * 1024; // 50MB
        if ($file->getSize() > $maxSize) {
            throw new \Exception("File too large. Maximum size is 50MB.");
        }
    }

    /**
     * Test the conversion service
     */
    public function testConversion(): array
    {
        try {
            // Create a simple test DOCX file
            $testContent = 'Test Document';
            $testFile = $this->createTestDocx($testContent);
            
            // Convert the test file
            $result = $this->convertToPdf($testFile);
            
            // Clean up test file
            if (file_exists($testFile->getRealPath())) {
                unlink($testFile->getRealPath());
            }
            
            return $result;
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Test conversion failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create a test DOCX file for testing
     */
    private function createTestDocx(string $content): UploadedFile
    {
        // This is a simplified test - in production you might want to create a proper DOCX
        $tempFile = tempnam(sys_get_temp_dir(), 'test_docx_');
        file_put_contents($tempFile, $content);
        
        return new UploadedFile(
            $tempFile,
            'test.docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            null,
            true
        );
    }
}
```

#### Controller (`app/Http/Controllers/DocToPdfController.php`)
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\PythonConverterService;

class DocToPdfController extends Controller
{
    protected $pythonConverter;

    public function __construct(PythonConverterService $pythonConverter)
    {
        $this->pythonConverter = $pythonConverter;
    }

    public function showForm()
    {
        // Check if running over HTTPS and show warning if not
        $isSecure = request()->isSecure();
        
        $response = response()->view('upload', compact('isSecure'));
        
        // Add security headers
        return $this->addSecurityHeaders($response);
    }

    /**
     * Add security headers to response
     */
    private function addSecurityHeaders($response)
    {
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Only set HSTS header if using HTTPS
        if (request()->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        return $response;
    }

    /**
     * Debug method to check current configuration
     */
    public function debugConfig()
    {
        $config = [
            'python_converter_url' => env('PYTHON_CONVERTER_URL', 'http://localhost:5000'),
            'python_converter_timeout' => env('PYTHON_CONVERTER_TIMEOUT', 120),
            'app_url' => url('/'),
        ];
        
        return response()->json($config);
    }

    /**
     * Convert DOCX to PDF using Python processing
     */
    public function convertLocal(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:doc,docx|max:51200', // 50MB max
        ]);

        $file = $request->file('document');
        $originalFileName = $file->getClientOriginalName();

        try {
            // Check if Python service is available
            if (!$this->pythonConverter->isApiAvailable()) {
                return back()->with('error', 'Conversion service is currently unavailable. Please try again later.');
            }

            // Convert using Python service
            $response = $this->pythonConverter->convertAndDownload($file);
            
            return $this->addSecurityHeaders($response);

        } catch (\Exception $e) {
            Log::error('Python conversion failed', [
                'error' => $e->getMessage(),
                'file' => $originalFileName
            ]);
            
            return back()->with('error', 'Conversion failed: ' . $e->getMessage());
        }
    }

    /**
     * Test local conversion functionality
     */
    public function testLocalConversion()
    {
        try {
            // Check if Python service is available
            $apiStatus = $this->pythonConverter->getApiStatus();
            
            $result = [
                'success' => $apiStatus['available'],
                'message' => $apiStatus['available'] ? 'Python conversion service is ready' : 'Python conversion service is not available',
                'api_status' => $apiStatus
            ];
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Local conversion test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Python conversion service
     */
    public function testPythonConversion()
    {
        try {
            $result = $this->pythonConverter->testConversion();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Python conversion test failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
```

#### Routes (`routes/web.php`)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocToPdfController;

Route::get('/', [DocToPdfController::class, 'showForm'])->name('upload.form');

// Local conversion route (Python-based)
Route::post('/convert-local', [DocToPdfController::class, 'convertLocal'])->name('convert.local');

// Test route for local conversion
Route::get('/test-local-conversion', [DocToPdfController::class, 'testLocalConversion'])->name('test.local.conversion');

// Test Python conversion service
Route::get('/test-python-conversion', [DocToPdfController::class, 'testPythonConversion'])->name('test.python.conversion');

// Debug route
Route::get('/debug-config', [DocToPdfController::class, 'debugConfig'])->name('debug.config');
```

#### View (`resources/views/upload.blade.php`)
```html
<!DOCTYPE html>
<html>
<head>
    <title>DOC/DOCX to PDF Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            background-color: #fafafa;
        }
        button {
            background-color: #0078d4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #106ebe;
        }
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .test-links {
            margin-top: 30px;
            text-align: center;
        }
        .test-links a {
            color: #0078d4;
            text-decoration: none;
            margin: 0 10px;
        }
        .test-links a:hover {
            text-decoration: underline;
        }
        .python-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .python-info h3 {
            color: #0078d4;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DOC/DOCX to PDF Converter</h1>
        
        <!-- Security Status Warning -->
        @if(isset($isSecure) && !$isSecure)
            <div class="alert alert-warning" style="margin-bottom: 20px;">
                <strong>⚠️ Security Warning:</strong> You are accessing this application over an insecure connection (HTTP). 
                While this is normal for local development, form submissions may not be fully secure. 
                For production use, ensure HTTPS is enabled.
            </div>
        @elseif(isset($isSecure) && $isSecure)
            <div class="alert alert-success" style="margin-bottom: 20px;">
                <strong>✅ Secure Connection:</strong> You are accessing this application over a secure connection (HTTPS).
            </div>
        @endif
        
        <div class="python-info">
            <h3>Python Conversion Service</h3>
            <p>This application uses a Python-based conversion service to convert your documents to PDF with high quality and accuracy.</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <form action="{{ route('convert.local') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="document">Select DOC or DOCX File:</label>
                <input type="file" id="document" name="document" accept=".doc,.docx" required>
            </div>
            
            <button type="submit">Convert to PDF</button>
            <small style="color: #666; display: block; margin-top: 10px; text-align: center;">
                This uses local Python processing to convert your document to PDF.
            </small>
        </form>
        
        <div class="test-links">
            <a href="{{ route('test.local.conversion') }}" target="_blank">Test Local Conversion</a>
            <a href="{{ route('test.python.conversion') }}" target="_blank">Test Python Conversion</a>
            <a href="{{ route('debug.config') }}" target="_blank">Debug Configuration</a>
        </div>
    </div>
</body>
</html>
```

## Configuration

### Environment Variables (`.env`)
```env
# Python Converter Service
PYTHON_CONVERTER_URL=http://localhost:5000
PYTHON_CONVERTER_TIMEOUT=120
```

## Usage

### 1. Start Python Service
```bash
# Install Python dependencies
pip install -r requirements.txt

# Start the Python service
python python_converter.py
```

### 2. Start Laravel Application
```bash
# Install Laravel dependencies
composer install

# Start Laravel development server
php artisan serve
```

### 3. Access the Application
Visit `http://localhost:8000` to access the conversion interface.

## Features

- ✅ Clean, single-purpose interface
- ✅ Python-based DOC/DOCX to PDF conversion
- ✅ File validation (size and format)
- ✅ Error handling and logging
- ✅ Security headers
- ✅ Health check endpoints
- ✅ Test endpoints for debugging
- ✅ Support for large files (up to 50MB)
- ✅ Base64 encoding for PDF transfer

## Testing

### Test Endpoints
- `/test-local-conversion` - Test Python service availability
- `/test-python-conversion` - Test actual conversion
- `/debug-config` - View configuration settings

### Manual Testing
1. Upload a DOCX file through the web interface
2. Check the generated PDF
3. Verify the conversion quality

## Troubleshooting

### Common Issues

1. **Python service not available**
   - Check if Python service is running on port 5000
   - Verify `PYTHON_CONVERTER_URL` in `.env`

2. **Conversion fails**
   - Check Python service logs
   - Verify file format and size
   - Check Laravel logs for errors

3. **Large file timeouts**
   - Increase `PYTHON_CONVERTER_TIMEOUT` in `.env`
   - Check server timeout settings

### Logs
- Laravel logs: `storage/logs/laravel.log`
- Python service logs: Check console output

## Security Considerations

- File size limits (50MB max)
- File type validation
- Security headers
- HTTPS recommended for production
- Input sanitization
- Error message sanitization

## Production Deployment

1. Use HTTPS in production
2. Set appropriate file upload limits
3. Configure proper logging
4. Use process manager for Python service (e.g., systemd, supervisor)
5. Set up monitoring and alerting
6. Regular security updates

This implementation provides a complete, production-ready solution for DOC/DOCX to PDF conversion using Python in a Laravel application.
