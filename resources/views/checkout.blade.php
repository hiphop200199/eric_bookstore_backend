<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            overflow-x: clip;
            scroll-behavior: smooth;
            font-size: clamp(20px, 2.4vw, 28px);
        }

      #container {
            position: relative;
            min-height: 100dvh;
            background-color: #f8f4e1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

            #title {
                margin-block: 0px 30px;
                font-size: 50px;
                text-align: center;
                color: #543310;
            }

            p {
                text-align: center;

                &#article {

                    &::first-letter {
                        font-size: clamp(32px, 3.4vw, 40px);
                        color: #543310;
                    }
                }
            }

            #to-search {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding-bottom: 50px;

                h3 {
                    font-size: 40px;
                    text-align: center;
                    color: #543310;
                }

                #texts {
                    margin-bottom: 50px;
                    font-size: 30px;
                    text-align: center;
                    color: #543310;
                }

                a {
                    text-decoration: none;
                    font-size: 25px;
                    background-color: #543310;
                    color: white;
                    padding: 5px;
                }

               
            }

            footer {
                background-color: #543310;
                color: white;
                text-align: center;
            }
        }
    </style>
    <title>eric_bookstore</title>
</head>

<body>
    <div id="container">
        <h1 id=title>Checkout complete!</h1>
        <p id="article">
            Thank you for your order,{{$user->name}}! Every purchase supports our small business and that means the world.
        </p>
        <section id="to-search">            
            <a href="https://hiphop200199.github.io/eric_bookstore" target="_blank">Visit Homepage</a>
        </section>
        <footer>
            <p id="copyright">Copyright © Reading 2024 | All Rights Reserved.</p>
        </footer>
    </div>
</body>

</html>
