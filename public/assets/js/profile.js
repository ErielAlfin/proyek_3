// ========== Edit Profil ==========
const editBtn = document.getElementById("editBtn");
const saveBtn = document.getElementById("saveBtn");
const inputs = document.querySelectorAll(".profile-info input");

editBtn.addEventListener("click", () => {
  inputs.forEach(input => input.disabled = false);
  editBtn.classList.add("hidden");
  saveBtn.classList.remove("hidden");
});

saveBtn.addEventListener("click", () => {
  inputs.forEach(input => input.disabled = true);
  editBtn.classList.remove("hidden");
  saveBtn.classList.add("hidden");
  alert("Data profil berhasil disimpan!");
});

// ========== Edit Foto Profil ==========
const uploadPhoto = document.getElementById("uploadPhoto");
const editPhotoBtn = document.getElementById("editPhotoBtn");
const profileImage = document.getElementById("profileImage");

editPhotoBtn.addEventListener("click", () => uploadPhoto.click());
uploadPhoto.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => profileImage.src = reader.result;
    reader.readAsDataURL(file);
  }
});

// ========== Modal Rating ==========
const ratingButtons = document.querySelectorAll(".btn-rating");
const modal = document.getElementById("ratingModal");
const closeModal = document.getElementById("closeModal");
const barberName = document.getElementById("barberName");
const stars = document.querySelectorAll(".star");
let selectedRating = 0;

ratingButtons.forEach(button => {
  button.addEventListener("click", () => {
    barberName.textContent = button.dataset.barber;
    modal.style.display = "flex";
  });
});

closeModal.addEventListener("click", () => {
  modal.style.display = "none";
  stars.forEach(s => s.classList.remove("active"));
  document.getElementById("comment").value = "";
});

stars.forEach(star => {
  star.addEventListener("click", () => {
    selectedRating = star.dataset.value;
    stars.forEach(s => s.classList.remove("active"));
    star.classList.add("active");
    let prev = star.previousElementSibling;
    while (prev) {
      prev.classList.add("active");
      prev = prev.previousElementSibling;
    }
  });
});

document.getElementById("submitRating").addEventListener("click", () => {
  const comment = document.getElementById("comment").value;
  if (selectedRating === 0 || comment.trim() === "") {
    alert("Silakan isi rating dan komentar terlebih dahulu.");
    return;
  }
  alert(`Rating ${selectedRating} ★ dan komentar terkirim untuk ${barberName.textContent}!`);
  modal.style.display = "none";
});
