let enter = (ele) => {
  document.getElementById("notfoundlabel").style.display = "none";
  // if (event.keyCode === 13) {
  setTimeout(() => {
    changePicture(ele.value);
    // TOO: altijd kunnen scannen
  }, 100);
  // }
};

let changePicture = (source) => {
  var img = new Image();
  img.src = "../copyhere/" + source + ".jpg";
  img.onerror = function noimage() {
    document.getElementById("notfoundlabel").style.display = "flex";
  };
  img.onload = function imagefound() {
    img = document.getElementById("image");
    img.src = "../copyhere/" + source + ".jpg";
    displayImage();
    // set cookie so carousel can show aswell
    setCookie('preview', "copyhere/" + source + ".jpg");
  };
};

let displayImage = () => {
  let input = document.getElementById("ticketinput");
  input.style.display = "none";
  let imagediv = document.getElementById("photos");
  imagediv.style.display = "flex";


};

let removeImage = () => {
  let input = document.getElementById("ticketinput");
  input.style.display = "flex";
  let imagediv = document.getElementById("photos");
  imagediv.style.display = "none";
};



document.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    setCookie('preview', 'remove');
    removeImage();
    document.getElementById("ticketinput").focus();
    document.getElementById("ticketinput").value = "";
  }
});

// print

function PrintImage() {
  setCookie('preview', 'print');
  pwin = window.open('print.php?url=' + document.getElementById("image").src, "_blank");
  pwin.onload = function () {
    pwin.print();
  };
  removeImage();
  document.getElementById("ticketinput").focus();
  document.getElementById("ticketinput").value = "";
}

function askDelete() {
  if (confirm("Weet je zeker dat je alle foto's wilt verwijderen? Zorg ervoor dat de 'foto carousel' eerst is afgesloten!")) {
    deleteCopies()
  } else {
    // Do nothing!
  }
}

function deleteCopies() {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", 'delete_copies.php', true);
  xhr.send();
}

function pressEsc() {
  setCookie('preview', 'remove');
  removeImage();
  document.getElementById("ticketinput").focus();
  document.getElementById("ticketinput").value = "";
}
function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

//email page
const scanInput = document.getElementById("scanPhotoSelect");
scanInput.addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    lookup(scanInput.value)
    scanInput.value = '';
  }
});

let list = new DataTransfer();
let inputField = document.getElementById("photos");
async function lookup(input) {
  // Create a new image object

  src = "../copyhere/" + input + ".jpg";
  let status = await checkIfPhotoExists(src);
  console.log(status)

  if (status == 1) {
    //if "1" the photo exists, then add to file array 
    let file = await createFile(src, input);
    list.items.add(file);
    let myFileList = list.files;
    inputField.files = myFileList;
    // fileArray.push(await createFile(src, input));
    // inputField.files = fileArray;
  } else if (status == 0){
    alert("foto not niet gevonden, run MOVESPUL op bureaublad")
  }
}

async function createFile(src, input) {
  let response = await fetch(src);
  let data = await response.blob();
  let metadata = {
    type: 'image/jpeg'
  };
  let file = new File([data], input+".jpg", metadata);
  // ... do something with the file or return it
  return file;
}

function conLog() {
  console.log(inputField.files[0])

}

function checkIfPhotoExists(path) {
  return new Promise((resolve) => {
    $.ajax({
      type: "POST",
      url: "doesPhotoExist.php",
      data: {
        src: path,
      },
      success: function (result) {
        resolve(result);
      }
    });
  });


}