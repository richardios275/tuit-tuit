<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
}
$username = $_SESSION['user_id'];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuit Tuit | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<style>
    .no_margin {
        margin: 0px;
    }


    .post-area {
        width: auto;
        background-color: rgb(64, 169, 58);
    }

    .post-squares {
        height: fit-content;
        margin: 20px;
        padding: 10px;
        background-color: white;
        box-sizing: border-box;
    }

    .image-preview {
        height: 200px;
        margin: 10px;

    }

    .image-preview-container {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        contain: size;
        height: 235px;
        margin-top: 10px;
    }
</style>

<body class="no_margin">
    <div style="display: flex; height: 100vh;">

        <div id="profile" style="display: none; flex: 2; flex-direction: column; padding: 20px;">

            <nav style="background-color: rgb(164, 103, 41);">
                <button style="margin: 5px;"> logout </button>

            </nav>
            <nav style="background-color: rgb(164, 103, 41);margin-top: 10px; padding-top: 20px;">
                <img src="" alt="">
                <h2 id="username"><?php echo $username ?></h2>
            </nav>
            <div class="post-area" id="leftFeed"
                style="margin-top: 10px; flex: 1; background-color: rgb(164, 103, 41);">
                posts are displayed in squares here
            </div>

        </div>

        <div id="feed" style="display:flex ; flex: 3; background-color: rgb(124, 240, 139);">

            <div id="handle" style="width: 20px; background-color: rgb(164, 103, 41); cursor: pointer;"
                onclick="toggleProfile()">

            </div>
            <div style="flex: 1; padding: 20px; flex-direction: column; display: flex;">
                <nav class="flex justify-around" style="background-color: rgb(64, 169, 58); text-align: center;">
                    <div></div>
                    <div>
                        <input type="text" id="searchBar" placeholder="Search..." style="margin: 5px;">
                    </div>
                    <div>
                        <button onclick="" </div>
                </nav>
                <div class="post-area" id="rightFeed" style="margin-top: 10px; flex: 1; overflow-y: auto; ">
                    <button onclick="loopMakePostSquares()">
                        test button
                    </button>
                    posts are displayed in squares here
                    <div class="post-squares">
                        <div>
                            Cara menjadi lorem ipsum sangatlah mudah, <br>
                            langkah pertama adalah harus melakukan dolor si amet <br>
                            yang kedua adalah [redacted] <br>
                            ketiga adalah... aku lupa :l <br>
                        </div>
                        <div class="image-preview-container">
                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="tall_image_test.png" alt="" class="image-preview">
                            <img src="wide_image_test.png" alt="" class="image-preview">
                        </div>

                    </div>
                    <div class="post-squares">
                        <div>
                            Cara menjadi lorem ipsum sangatlah mudah, <br>
                            langkah pertama adalah harus melakukan dolor si amet <br>
                            yang kedua adalah [redacted] <br>
                            ketiga adalah... aku lupa :l <br>
                        </div>
                        <div class="image-preview-container">

                            <img src="square_image_test.png" alt="" class="image-preview">
                            <img src="tall_image_test.png" alt="" class="image-preview">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
    crossorigin="anonymous"></script>

<script>
    //document.ready.function
    profile = document.getElementById("profile")
    feed = document.getElementById("feed")
    handle = document.getElementById("handle")

    searchBarQuery = document.getElementById("searchBar")

    const texts = ["chess battle advanced", "Chess fight improved", "Checkers truce simple"]
    const mediaSets = [["square_image_test.png"], [], ["tall_image_test.png", "wide_image_test.png"]]

    postArea = document.getElementById("rightFeed")

    function toggleProfile() {
        if (profile.style.display == 'none') {
            profile.style.display = 'flex';
        } else {
            profile.style.display = 'none';
        }
    }

    function makePostSquares(text, mediaSet) {
        var postSquare = document.createElement("div");
        postSquare.classList.add("post-squares");
        postSquare.appendChild(document.createTextNode(text));
        if (mediaSet.length == 0) {
            postArea.appendChild(postSquare);
            return;
        }
        var imagePreview = document.createElement("div");
        imagePreview.classList.add("image-preview-container");

        //idk how to make efficient loop for this.

        mediaSet.forEach(media => {
            var theMedia = document.createElement("img");
            theMedia.src = media;
            theMedia.classList.add("image-preview");
            imagePreview.appendChild(theMedia);
        });
        postSquare.appendChild(imagePreview);
        postArea.appendChild(postSquare);
    }

    //nb to richard: please make sure the length of texts and mediaSets are the same, or else this will break

    function loopMakePostSquares() {
        var len = texts.length
        alert("ooh")
        for (i = 0; i < len; i++) {
            alert("aah!")
            makePostSquares(texts[i], mediaSets[i])
        }
        alert("baby")
    }

</script>

</html>