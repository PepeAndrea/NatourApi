<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riepilogo percorso</title>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
       td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
        </style>
</head>
<body>
    <h1>{{$path->title}}</h1>
    <p>{{$path->description}}</p>
    <div style="display: flex;flex-direction: horizontal">
        <h3 style="padding-right: 30px">Lunghezza: {{$path->length}}km</h3>
        <h3 style="padding-right: 30px">Durata: {{$formattedDuration}}</h3>
        <h3 style="padding-right: 30px">Difficoltà: {{$path->difficulty}}</h3>
    </div>

    <h2>Punti di interesse</h2>
    
    <table>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Latitudine</th>
            <th>Longitudine</th>
          </tr>
        @foreach ($path->interestPoints as $interestPoint)
        <tr>
            <th>{{$interestPoint->title}}</th>
            <th>{{$interestPoint->category}}</th>
            <th>{{$interestPoint->latitude}}</th>
            <th>{{$interestPoint->longitude}}</th>
        </tr>
        @endforeach
    </table>


</body>
</html>