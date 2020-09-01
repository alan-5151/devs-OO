<html>
    <head>
        <title>Modal sem JS</title>
        <style>

            .modal {
                position: fixed;
                top: 10%;
                right: 10%;
                bottom: 10%;
                left: 20%;
                font-family: Arial, Helvetica, sans-serif;
               
                z-index: 99999;
                opacity:0;
                -webkit-transition: opacity 400ms ease-in;
                -moz-transition: opacity 400ms ease-in;
                transition: opacity 400ms ease-in;
                pointer-events: none;
            }

            .modal:target {
                opacity: 1;
                pointer-events: auto;
            }

           


            .fechar {
                position: absolute;
                width: 30px;
                right: -15px;
                top: -20px;
                text-align: center;
                line-height: 30px;
                margin-top: 5px;
                background: #ff4545;
                border-radius: 50%;
                font-size: 16px;
                color: #8d0000;
            }

        </style>
    </head>
    <body>

        <a href="#abrirModal">Open Modal</a>

        <div id="abrirModal" class="modal">
            <a href="#fechar" title="Fechar" class="fechar">x</a>
            <img src="media/uploads/5049d3ce86b7ccd032b2ce698e7804bb.jpg" />
        </div>



    </body>
</html>