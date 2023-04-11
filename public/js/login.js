let inputs = document.querySelectorAll('input');

let labels = document.querySelectorAll('label');

for(let i=0; i<inputs.length; i++)
{
    inputs[i].addEventListener('keyup', ()=>{
        if(inputs[i].value.length > 0)
        {
            labels[i].classList.add('active');
            labels[i].style.color = 'black';
        }
        else
        {
            labels[i].classList.remove('active');
            labels[i].style.color = 'white';
        }

    })

}
