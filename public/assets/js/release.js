fetch('/github/releases', { method: 'GET' })
  .then(response => response.json())
  .then(data => {

    if (!data || data.length === 0) {
      document.getElementById('releaseList').innerText = 'No releases available.';
      return;
    }

    const release = data[0]; 
    const releaseVersion = release.tag_name; 
    const releaseLink = release.html_url; 
    const changeLog = release.body;

    // Format the release details
    document.getElementById('latestRelease').innerHTML = `
      <div class="release-box">
        <label><a href="${releaseLink}" target="_blank">${releaseVersion}</a></label>
      </div>
    `;

    // Format the release details
    // document.getElementById('releaseList').innerHTML = `
    //   <div class="release-box">
    //     <label><a href="${releaseLink}" target="_blank">What's changed  on ${releaseVersion}</a></label>
    //   </div>
    // `;

    const lines = changeLog
      .replace('## What\'s Changed', '')
      .trim()
      .split(/\r?\n/); 

    const formattedLines = lines.map(line => {
      const content = line.replace(/^\*\s*/, '').trim(); 
      return `<li>${content}</li>`;
    });

const formattedBody = `
  <div class="content-box">
    <ul>${formattedLines.join('')}</ul>
  </div>
`;
    document.getElementById('changeLog').innerHTML = formattedBody;

  })
  .catch(error => {
    console.error('Error fetching releases:', error);
    document.getElementById('releaseList').innerText = 'Release version not found';
  });
