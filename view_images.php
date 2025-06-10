<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Picture Point</title>
    <style>
        body {
        font-family: "Montserrat", sans-serif;
        font-weight: 400;
        font-style: normal;
        height: 100vh;
        background-image: url("background.jpg");
        background-size: cover;
        width: 100vw;
        margin: 0px;
        text-transform: uppercase;
        overflow: overlay;
        user-select: none;
        }
        ::-webkit-scrollbar {
        width: 10px;
        }

        .row::after {
        content: "";
        clear: both;
        display: table;
        }
        .p {
            font-size: 22px;
            font-family: monospace;
        }

        .card {
        float: left;
        box-sizing: border-box;
        height: 100%;
        width: 159px;
        margin: 10px 10px;
        background: #fcfd86;
        border: 10px #fcfd86 solid;
        border-bottom: 5px #fcfd86 solid;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0px 1px 20px 1px rgb(0 0 0 / 15%);
        position: relative;
        }
        .card img {
        height: 200px;
        width: auto;
        filter: saturate(1.2) contrast(1.1);
        }
        .card .logo {
        position: absolute;
        width: 55%;
        height: 4%;
        background-image: url(logomagic.png);
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
        bottom: -47px;
        left: 22.5%;
        }

        .btn {
        padding: 8px;
        height: 50px;
        width: 100px;
        position: absolute;
        right: 5%;
        bottom: 20%;
        opacity: .6;
        background-color: rgba(220, 103, 255, 0.524);
        border: 2px white solid;
        border-radius: 5%;
        color: white;
        }

        .del {
            width: 30px;
            height: 30px;
            position: absolute;
            background-color: #fb4c4c;
            border-radius: 100%;
            top: 3px;
            right: 5px;
        }
    </style>
</head>

<body>
    <div id="image-wrapper">
        <div id="row" class="row"></div>
    </div>
</body>

<script>
    // init
    var ActiveImageArray = [];
    checkNewImages();
    doBatch();
    
    // this function (re)loads the image elements
    function loadDOM() {
        if(ActiveImageArray.length < 1) {
            // dont do shit
        }
        else {
            let row = document.getElementById('row');
            console.log(row.hasChildNodes());
            if(row.hasChildNodes()) { // if there is something in the container
                console.log('psssst');
                while (row.firstChild) { // then.. ..DELETE IT WAHAHAHAHAHAHAHA I HAVE POWAAAAAAAA
                    row.removeChild(row.lastChild);
                }
            }
            ActiveImageArray.forEach(function (item){
                let card = document.createElement('div');
                card.setAttribute("class", "card");
                let img = document.createElement('img');
                img.setAttribute("src", item);
                let p = document.createElement('span');
                var code = item.substring(
                    item.indexOf("/") + 1, 
                    item.lastIndexOf(".")
                );
                p.innerHTML = code;      
                p.setAttribute("class", "p");
                let del = document.createElement('div');
                del.setAttribute("class", "del");
                del.setAttribute("onClick", "delete('"+item+"')");
                
                row.appendChild(card);
                card.appendChild(img);
                card.appendChild(p);
                card.appendChild(del);
            });
            
        }
    }

    // here we check if there are more images in the source folder AKA new images
    function checkNewImages() {
        let newImageArray = getImages();
        if(newImageArray.length > ActiveImageArray.length) {
            console.log('new images found!');
            ActiveImageArray = newImageArray;
            loadDOM();
        }
        else {
            console.log('I did check but there are no new images');
        }
    }

    // this sends a GET REQUEST to a PHP script that gathers all the URL's of these images
    function getImages() {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open( "GET", 'get_images.php', false ); // false for synchronous request
        xmlHttp.send( null );
        return JSON.parse(xmlHttp.responseText);
    }

    // this will sends a POST REQUEST to an other PHP script that will copy and paste 
    // the images from the shared folder into the copyhere folder
    function doBatch() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", 'do_batch.php', true);
        xhr.send();
    }

    function delete(location) {
        
    }
</script>

</html>