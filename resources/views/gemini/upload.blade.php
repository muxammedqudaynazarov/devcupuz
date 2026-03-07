<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemini Tahlili</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        textarea, input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .result-box { background-color: #f8f9fa; border-left: 4px solid #28a745; padding: 15px; margin-top: 20px; white-space: pre-wrap; }
    </style>
</head>
<body>

<h2>Talaba ishlari uchun Gemini Tahlili</h2>

{{-- Xatoliklarni ko'rsatish --}}
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('gemini.analyze') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="document">Talaba ishini yuklash (PDF, JPG, PNG):</label>
        <input type="file" name="document" id="document" required>
    </div>

    <div class="form-group">
        <label for="prompt">API ga beriladigan buyruq (Prompt):</label>
        <textarea name="prompt" id="prompt" rows="5" required>{{ old('prompt', $prompt ?? 'Ushbu hujjatdagi talaba javoblarini tahlil qil va berilgan savollarga qanchalik to\'g\'ri javob berganini 10 ballik tizimda bahola.') }}</textarea>
    </div>

    <button type="submit">Tahlil qilish</button>
</form>

{{-- Natijani shu yerda ko'ramiz --}}
@if(isset($result))
    <hr>
    <h3>API Natijasi:</h3>
    <div class="result-box">
        {{ $result }}
    </div>
@endif

</body>
</html>
