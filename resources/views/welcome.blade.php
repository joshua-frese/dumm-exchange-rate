<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @livewireStyles

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
    
            .container {
                max-width: 500px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
    
            h1 {
                font-size: 24px;
                color: #333;
                text-align: center;
                margin-bottom: 20px;
            }
    
            label {
                font-size: 14px;
                color: #555;
                display: block;
                margin-bottom: 5px;
            }
    
            select, input[type="text"] {
                width: calc(100% - 22px);
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }
    
            input[type="text"]:focus, select:focus {
                border-color: #007bff;
                outline: none;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }
    
            .rate-display {
                font-size: 14px;
                color: #007bff;
                text-align: center;
                margin-bottom: 20px;
            }
    
            .result-display {
                font-size: 18px;
                color: #28a745;
                text-align: center;
                margin-top: 20px;
            }

            .error-message {
                color: #b11e2d;
                padding: 0 15px 15px;
                font-size: 14px;
                font-weight: bold;
                text-align: center;
            }
        </style>
       
    </head>
    <body class="antialiased">
        <livewire:exchange-rate /> 

        @livewireScripts
    </body>
</html>
