console.log("UMA MUSUME");

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

postBody.addEventListener("input", (e) => {
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
});
