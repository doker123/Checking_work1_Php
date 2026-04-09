document.getElementById('userType').addEventListener('change', function() {
    const val = this.value;
    document.getElementById('directorFields').classList.toggle('active', val === 'director');
    document.getElementById('aspirantFields').classList.toggle('active', val === 'aspirant');
});