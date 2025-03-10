function showSection(sectionId) {
  document.querySelectorAll('.menu-section').forEach(section => {
      section.style.display = 'none';
  });
  document.getElementById(sectionId).style.display = 'block';
}