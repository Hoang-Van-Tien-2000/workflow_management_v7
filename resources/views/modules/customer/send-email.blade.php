<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Raleway:ital,wght@1,200&display=swap");

        * {
            margin: 0;
            padding: 0;
            border: 0;
        }

        body {
            font-family: "Raleway", sans-serif;
            background-color: #d8dada;
            font-size: 19px;
            max-width: 800px;
            margin: 0 auto;
            padding: 3%;
        }

        img {
            width: 100%;
        }

        header {
            width: 98%;
        }

        #logo {
            max-width: 120px;
            margin: 3% 0 3% 3%;
            float: left;
        }

        #wrapper {
            background-color: #f0f6fb;
        }

        #banner img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        #social {
            float: right;
            margin: 3% 2% 4% 3%;
            list-style-type: none;
        }

        #social>li {
            display: inline;
        }

        #social>li>a>img {
            max-width: 35px;
        }

        h1,
        p {
            margin: 3%;
        }

        .btn {
            float: right;
            margin: 0 2% 4% 0;
            background-color: #303840;
            color: #f6faff;
            text-decoration: none;
            font-weight: 800;
            padding: 8px 12px;
            border-radius: 8px;
            letter-spacing: 2px;
        }

        hr {
            height: 1px;
            background-color: #303840;
            clear: both;
            width: 96%;
            margin: auto;
        }

        #contact {
            text-align: center;
            padding-bottom: 3%;
            line-height: 16px;
            font-size: 12px;
            color: #303840;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <header>
            <div id="logo">
                <img src="https://mdbgo.io/dawidadach/responsiveemail/img/logo.png" alt="" />
            </div>
            <div>
                <ul id="social">
                    <li>
                        <a href="#" target="_blank"><img
                                src="https://mdbgo.io/dawidadach/responsiveemail/img/fb-color.png" alt="" /></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img
                                src="https://mdbgo.io/dawidadach/responsiveemail/img/in-color.png" alt="" /></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img
                                src="https://mdbgo.io/dawidadach/responsiveemail/img/tw-color.png" alt="" /></a>
                    </li>
                    <li>
                        <a href="#" target="_blank"><img
                                src="https://mdbgo.io/dawidadach/responsiveemail/img/yt-color.png" alt="" /></a>
                    </li>
                </ul>
            </div>
        </header>
        <div id="banner">
            <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=868&q=80"
                alt="" />
        </div>
        <div class="one-col">
            <h1>{{ $title }}</h1>
            <p>
                {{ $content }}
            </p>
            <hr />
            <footer>
                <p id="contact">contact@gmail.com</p>
            </footer>
        </div>
    </div>
</body>

</html>
