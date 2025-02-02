document.getElementById("tombol-home").addEventListener("click", function() {
    window.location.href = "./";
  });

const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')
  
myModal.addEventListener('shown.bs.modal', () => {
    myInput.focus()
})

const firstnameInput = document.querySelector('input[name="firstname"]');
const lastnameInput = document.querySelector('input[name="lastname"]');

firstnameInput.addEventListener('input', function() {
  if (this.value.length > 255) {
    this.value = this.value.substring(0, 255);
  }
});

lastnameInput.addEventListener('input', function() {
  if (this.value.length > 255) {
    this.value = this.value.substring(0, 255);
  }
});