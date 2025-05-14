// fetch('/github/releases', {
//   method: 'GET',
// })
// .then(response => response.json())
// .then(data => {
//   console.log('Fetched JSON data:', data);
//   if (data.length > 0) {
//     const release = data[0]; 

//     const releaseVersion = release.tag_name; 
//     const releaseLink = release.html_url; 
//     const body = release.body; 

//     const releaseElement = document.getElementById('releaseList');
//     releaseElement.innerHTML = `<label><a href="${releaseLink}" target="_blank">${releaseVersion}</a></label>`;

//     const bodyElement = document.getElementById('body');
//     bodyElement.innerHTML = `<div class="content-box"><p>${body}</p></div>`;

//   } else {
//     document.getElementById('releaseList').innerText = 'No releases available.';
//   }
// })
//  .catch(error => {
//   console.error('Error fetching releases:', error);
//   document.getElementById('releaseList').innerText = 'Error fetching release data.';
// });

fetch('/github/releases', { method: 'GET' })
  .then(response => response.json())
  .then(data => {
    console.log('Fetched JSON data:', data);

    if (!data || data.length === 0) {
      document.getElementById('releaseList').innerText = 'No releases available.';
      return;
    }

    const release = data[0]; 
    const releaseVersion = release.tag_name; 
    const releaseLink = release.html_url; 
    const body = release.body;

    // Format the release details
    document.getElementById('releaseList').innerHTML = `
      <div class="release-box">
        <label><a href="${releaseLink}" target="_blank">${releaseVersion}</a></label>
      </div>
    `;

    // Convert Markdown-style text into formatted HTML
    const formattedBody = body
      .replace('## What\'s Changed', '<h3>What\'s Changed</h3>')  // Convert header
      .replace(/\r\n\*/g, '</li><li>')  // Convert bullet points (* item) into list items
      .replace(/\r\n/g, '<br>');  // Preserve line breaks

    document.getElementById('body').innerHTML = `
      <div class="content-box">
        <ul><li>${formattedBody}</li></ul>
      </div>
    `;
  })
  .catch(error => {
    console.error('Error fetching releases:', error);
    document.getElementById('releaseList').innerText = 'Error fetching release data.';
  });
