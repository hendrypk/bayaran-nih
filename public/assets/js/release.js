fetch('/github/releases', {
  method: 'GET',
})
.then(response => response.json())
.then(data => {
  if (data.length > 0) {
    const release = data[0]; 

    const releaseVersion = release.tag_name; 
    const releaseLink = release.html_url; 

    const releaseElement = document.getElementById('releaseList');
    releaseElement.innerHTML = `${releaseVersion}`;

  } else {
    document.getElementById('releaseList').innerText = 'No releases available.';
  }
})
 .catch(error => {
  console.error('Error fetching releases:', error);
  document.getElementById('releaseList').innerText = 'Error fetching release data.';
});





