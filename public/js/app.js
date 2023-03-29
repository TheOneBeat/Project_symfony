let forms = document.querySelectorAll('form');
forms.forEach(e=>{
    e.addEventListener('submit', event=> {
        event.preventDefault();
    })
})
