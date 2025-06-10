let amountofimages = 0;
let imagefound = true;
var i = 1; //  set your counter to 1

function countimages() {
  var img = new Image();
  img.src = "copyhere/" + i + ".jpg";

  img.onload = () => {
    amountofimages++;
    i++;
    countimages();
  };

  img.onerror = () => {
    console.log("image found false");
    imagefound = false;
    console.log(amountofimages);
    // maak images
    maakimages();
  };
}

countimages();

let maakimages = () => {
  let imagegrid = document.createElement("div");
  imagegrid.className = "imagegrid";
  imagegrid.id = "imagegrid";
  let j = 0;
  for (let i = 1; i < amountofimages + 1; i++) {
    let imagediv = document.createElement("div");
    imagediv.className="imagediv";

    let image = document.createElement("img");
    image.src = "copyhere/" + i + ".jpg";
    image.className = "smallimage";

    let imageindex = document.createElement("p");
    imageindex.innerHTML = i;
    imageindex.className = "imageindex";

    imagediv.appendChild(imageindex);
    imagediv.appendChild(image);

    imagegrid.appendChild(imagediv);

    document.getElementsByTagName("body")[0].appendChild(imagegrid);
    if (i % 12 === 0) {
      j++;
      imagegrid = document.createElement("div");
      imagegrid.className = "imagegrid";
      imagegrid.id = "imagegrid" + j + 2;
      imagegrid.style.display = "none";
    }
  }
};

let imagegrids;
let gridslength = 0;
setTimeout(() => {
  imagegrids = document.getElementsByClassName("imagegrid");
  gridslength = imagegrids.length;
  // imagegrids[0].style.display = "none";
  console.log(imagegrids);
}, 1000);


let currentpage = 0;
let nextpage = () => {
  let pageindex = 0;
  for (let item of imagegrids) {
    if (currentpage === gridslength -1) {
      // currentpage = -1;
      // console.log("currentpage is -1");
      location.reload();
    }
    if (currentpage + 1 === pageindex) {
      item.style.display = "grid";
    } else {
      item.style.display = "none";
    }
    pageindex++;
  }
  currentpage++;
};

setInterval(nextpage, 10000);