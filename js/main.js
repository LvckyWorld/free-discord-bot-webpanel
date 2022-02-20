
for (let i = 0; i < document.getElementsByClassName('card').length; i++) {
    document.getElementsByClassName('card')[i].addEventListener('click', function() {
        this.classList.toggle('flip');
    });
}