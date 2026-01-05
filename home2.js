console.log("UMA MUSUME");

// [[ Post AJAX ]]
function refreshPosts(query) {
  let postAPI = '/api/get_posts.php';
  if (query != null) {
    postAPI = `/api/get_posts.php?query=${query}`;
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