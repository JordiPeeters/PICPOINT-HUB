<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Picture Point</title>
</head>

<body>
    <div id="image-wrapper">
        <div id="row" class="row"></div>
    </div>
</body>

<script>
    // init
    var ActiveImageArray = [];
    pageScroll();
    infiniteCheckFunction(10);

    var checkCookie = function() {
        var lastCookie = document.cookie; // 'static' memory between function calls
        return function() {
            var currentCookie = document.cookie;
            console.log(lastCookie);
            if (currentCookie != lastCookie) {
                let val = currentCookie.split('=')[1];
                console.log(val);
                switch (val) {
                    case 'remove':
                        document.getElementById('preview-img').classList.add("animate__animated", "animate__rollOut");
                        setTimeout(function () {
                            document.getElementById('preview-bg').remove();
                            document.getElementById('preview-img').remove();
                        }, 1000);
                        break;
                    case 'print':
                        document.getElementById('preview-img').classList.add("animate__animated", "animate__slideOutDown");
                        setTimeout(function () {
                            document.getElementById('preview-bg').remove();
                            document.getElementById('preview-img').remove();
                        }, 1000);
                        break;
                    default:
                        // alert(currentCookie.split('=')[1]);
                        let bg = document.createElement('div');
                        bg.setAttribute("id", 'preview-bg');
                        let img = document.createElement('img');
                        img.setAttribute("src", currentCookie.split('=')[1]);
                        img.setAttribute("id", 'preview-img');
                        document.body.appendChild(bg);
                        bg.appendChild(img);
                        document.getElementById('preview-img').classList.add("animate__animated", "animate__fadeInDownBig");
                        break;
                }
                lastCookie = currentCookie; // store latest cookie
            }
        };
    }();
    window.setInterval(checkCookie, 500); // run every 500 ms

    // runnning this script will make a infinite loop with a variable time delay
    function infiniteCheckFunction(waitTimeInSeconds) {
        let ms = waitTimeInSeconds * 1000;
        // every x miliseconds
        checkNewImages();
        doBatch();
        setTimeout(function(){ infiniteCheckFunction(waitTimeInSeconds); }, ms);
    }

    // horizontal scroll that is nice and smooth
    function pageScroll() {
        let el = document.getElementById('row');
        var limit = el.scrollWidth - el.clientWidth;
        el.scrollBy(1,0);
        scrolldelay = setTimeout(pageScroll,30);
        let estimatedPosition = el.scrollLeft + 5;
        if(estimatedPosition > limit) {
            
            if(ActiveImageArray.length > 4) {
                console.log("reached limit!");
                el.classList.add("hide");
                resetDelay = setTimeout(function() {
                    el.scrollLeft = 0;
                    el.classList.remove("hide");
                },1000);
            }
        }
    }
    
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
                const rndInt = randomIntFromInterval(-3, 3);
                card.setAttribute("style", "transform: rotate("+rndInt+"deg)");
                card.setAttribute("class", "card");
                let logo = document.createElement('span');
                logo.setAttribute("class", "logo");
                let img = document.createElement('img');
                img.setAttribute("src", item);
                
                row.appendChild(card);
                card.appendChild(logo);
                card.appendChild(img);
            });
            
        }
    }

    // here we check if there are more images in the source folder AKA new images
    function checkNewImages() {
        let newImageArray = getImages();
        // console.log(newImageArray);
        // console.log('==========================');
        // console.log(ActiveImageArray);
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

    // a random int generator with a min and max
    function randomIntFromInterval(min, max) { // min and max included 
        return Math.floor(Math.random() * (max - min + 1) + min)
    }

</script>

</html>