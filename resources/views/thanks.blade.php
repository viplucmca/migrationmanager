<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>
    <h2>Thank You !!</h2>
    <p>{{ $message ?? 'Congratulations, your query has been submitted successfully.' }}</p>
    @if($downloadUrl)
        <p>Your signed document is ready: <a href="{{ $downloadUrl }}" id="downloadLink">Download</a></p>
        <script>
            window.onload = function() {
                document.getElementById('downloadLink').click();
            }
        </script>
    @endif

	<div class="mt-6 text-center">
		<a
			href="{{ route('documents.index', $id) }}"
			class="text-blue-600 dark:text-blue-400 hover:underline"
		>
			Back to Document
		</a>
	</div>
</body>
</html>
