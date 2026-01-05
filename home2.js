console.log("UMA MUSUME");

// [[ Post AJAX ]]
function refreshPosts(query) {
  let postAPI = 'api/get_posts.php';
  if (query != null) {
    postAPI = `api/get_posts.php?query=${query}`;
  }

  fetch(postAPI)
  .then(response => {
    if (response.ok) {
      return response.json();
    } else {
      throw new Error('Response failure')
    }
  })
  .then(data)
}

// [[ Upload modal ]]
const uploadModal = document.getElementById("uploadModal");
const postBody = document.getElementById("post-body");
const postLimit = document.getElementById("post-limit");

// Focus
if (uploadModal) {
  postBody.focus();
}

// Limit Text
const textLimit = 300;
const cjkRegex =
  /[\u3040-\u309F\u30A0-\u30FF\u4E00-\u9FFF\u3400-\u4DBF\uAC00-\uD7AF\u3130-\u318F\u1100-\u11FF]/g;

function countCharacters(text) {
  const cjkMatches = text.match(cjkRegex);
  const cjkCount = cjkMatches ? cjkMatches.length : 0;
  const nonCjkCount = text.length - cjkCount;
  return cjkCount * 2 + nonCjkCount;
}

function showLimitFeedback() {
  console.log("Ye Shunguang's big schlong")
  postBody.classList.add("shake")
  setTimeout(() => {
        postBody.classList.remove('shake');
      }, 500);
}

// This is to handle Firefox bs
postBody.addEventListener("input", postBodyEvent);
postBody.addEventListener("keyup", postBodyEvent);
postBody.addEventListener("change", postBodyEvent);
postBody.addEventListener("paste", postBodyEvent);
postBody.addEventListener("cut", postBodyEvent);

function postBodyEvent(e) {
  newBody = e.target.value
  bodyLength = countCharacters(newBody);

  // Remove red border from error
  if (bodyLength <= textLimit) {
    if (postBody.classList.contains('border-danger')) {
      postBody.classList.remove('border-danger')
    }
    if (postLimit.classList.contains('text-danger')) {
      postLimit.classList.remove('text-danger')
    }
  }

  // Remove text if exceeds limit
  if (bodyLength > textLimit) {
    if (e.data != null) {
      postBody.value = newBody.slice(0, -1 * (countCharacters(e.data)));
      showLimitFeedback();
    }
  }

  postLimit.innerHTML = Math.min(bodyLength, 300) + "/" + textLimit;
}