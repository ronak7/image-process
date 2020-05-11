<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
       <form method="POST" action="/pattern">
            @csrf
            <input type="number" name="number" id="number" autofocus>
            <input type="submit" value="Create">
        </form>

        @if(isset($number))
            @if($number > 0)
                @php
                    for($i=0; $i<$number; $i++){
                        for($sp=0; $sp<($number-$i); $sp++){
                            echo "&nbsp;&nbsp;&nbsp;";
                        }
                        $n = 1;
                        for($j=0; $j<=$i; $j++){
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;". $n."";
                            $n= $n * ($i-$j) / ($j+1);
                        }
                        echo "<br>";
                    }
                @endphp
            @endif
        @endif
    </body>
</html>
