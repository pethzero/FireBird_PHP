<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Example</title>
</head>
<body>
    <h1>WebSocket Example</h1>

</body>
<script>
        // var conn = new WebSocket('ws://192.168.1.205:8080');
        var conn = new WebSocket('ws://localhost:8080');

        

        conn.onopen = function(e) {
            console.log("Connection established!");
            conn.send('Hello World!');
        };

        conn.onmessage = function(e) {
            console.log(e.data);
        };
    </script>
</html>
