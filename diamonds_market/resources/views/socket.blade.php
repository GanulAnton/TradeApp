<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>WebSockets Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
</head>

<body>

<script>
    var app = {
        'id': 'id',
        'key' : 'key',
        'host' : '127.0.0.1',
        'wsPort' : '6001',
        'authEndpoint' : '/broadcasting/auth',
        'token' : 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTE2Y2NjNWVlODUzOTgwYjMyNDA2YmNlYzkyODJmMGE2NWRlZWE0NGEzNmE0ODFmYjMxYjM3ZTQ1ZTA5ZGI1ZDY5YzNiMzA0NGIwOTM1MTgiLCJpYXQiOjE2MjY4NzkzMDguMTMxMTM0LCJuYmYiOjE2MjY4NzkzMDguMTMxMTQsImV4cCI6MTY1ODQxNTMwOC4xMjM3MTUsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.HaEa0NedKNd524WM90sQrUykqAobBcAptuWXilHz-m4uVED0xh2hiG5PGh5NXHHKoMfhXXppRjevgNSoksX3s70HPu27I00z_VeBivSlbHQ7_ZOh_WR1XWJ067PknwlU6LFIR8sLTaMYHozP4jou6cEWCyBLVRPlWPYMDqIufzj9DBYF49vstq_8XSoPTuxv7y6Oi9936RWbn8FvM5AkVBZJOSOiPyi5DnjV0-uK78aNCKN3t2k1R_A43wMUwxL5GEZEznqEvmHYn022myRZvHUWPpiFbnHY5fItkcYhxZbkTuAZwKbYTETe0DNLi9HLQ28aS8xWJREV7JuOSYqgwL4z1G5cVHdQno8TPsGDF9f5r93XrH4ZGOjaV4aJNI81hmvT4gjlV2yBHCQ1VcxrV2ckppZ6QFZVBaFcE06h8rL5O0w2JqfdKZ8wSZJ_8rmp-blaNjpMQo0zhCp6l7zewalYTwiSkywl7gDQfjSWR9Ie3LN1UugZMb_OfZmzMupE3XyLHjfQw3NvV-N-EKS0PeycVXST5npQ6eDetjZpoxs-VDqfNlRwj_ifququ3mB1C0NFxihQkfC9mr-5wswda_KYUhTIZ8eIkCi2D2TpxhG1ExNkvJIhXGLWWLwfHJs3s1LE3dEJy2SGqo6t2AbBseDCVQbpcmwL7bZsI8sXL0I'
    };

    var pusher = new Pusher(this.app.key, {
        wsHost: app.host,
        wsPort: app.wsPort,
        disableStats: true,
        authEndpoint: app.authEndpoint,
        auth: {
            headers: {
                'Authorization' : 'Bearer ' + app.token,
                'X-App-ID': this.app.id
            }
        },
        enabledTransports: ['ws', 'flash']
    });
    pusher.connection.bind('connected', () => {
        console.log('connected');
        pusher.subscribe('private-user.2')
            .bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (data) => {
                console.log(data);
            });
    });

</script>

</body>
</html>
