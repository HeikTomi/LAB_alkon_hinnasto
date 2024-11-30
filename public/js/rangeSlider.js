// JavaScript to handle the display of selected filter values
const bottleSizeMin = document.getElementById('bottleSizeMin');
const bottleSizeMax = document.getElementById('bottleSizeMax');
const priceMin = document.getElementById('priceMin');
const priceMax = document.getElementById('priceMax');
const energyMin = document.getElementById('energyMin');
const energyMax = document.getElementById('energyMax');

const bottleSizeDisplayMin = document.getElementById('bottleSizeDisplayMin');
const bottleSizeDisplayMax = document.getElementById('bottleSizeDisplayMax');
const priceDisplayMin = document.getElementById('priceDisplayMin');
const priceDisplayMax = document.getElementById('priceDisplayMax');
const energyDisplayMin = document.getElementById('energyDisplayMin');
const energyDisplayMax = document.getElementById('energyDisplayMax');

// Update displayed values when sliders change
bottleSizeMin.addEventListener('input', function() {
    bottleSizeDisplayMin.textContent = this.value;
});
bottleSizeMax.addEventListener('input', function() {
    bottleSizeDisplayMax.textContent = this.value;
});
priceMin.addEventListener('input', function() {
    priceDisplayMin.textContent = this.value;
});
priceMax.addEventListener('input', function() {
    priceDisplayMax.textContent = this.value;
});
energyMin.addEventListener('input', function() {
    energyDisplayMin.textContent = this.value;
});
energyMax.addEventListener('input', function() {
    energyDisplayMax.textContent = this.value;
});