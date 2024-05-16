function updateCurrentDate() {
    var currentDate = new Date();
    var day = currentDate.getDate().toString().padStart(2, '0');
    var month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    var year = currentDate.getFullYear();
  
    var dateInput = document.getElementById("date");
    dateInput.value = year + "-" + month + "-" + day;
  }
  
  function updatePrice() {
    var activite = document.getElementById("activite").value;
    var nombrePersonnes = document.getElementById("nombre_personnes").value;
    var prixElement = document.getElementById("prix");
  
    var prixUnitaire;
    var duree;
  
    switch (activite) {
      case "kayak":
        prixUnitaire = 50;
        duree = "2 heures";
        break;
      case "paddle":
        prixUnitaire = 100;
        duree = "2 heures";
        break;
      case "catamaran":
        prixUnitaire = 200;
        duree = "1 heure";
        break;
      case "surf":
        prixUnitaire = 100;
        duree = "2 heures";
        break;
    }
  
    var prixTotal = prixUnitaire * nombrePersonnes;
  
    prixElement.textContent = prixTotal + "dh (" + duree + ")";
  }
  
  function updateHours() {
    var activitySelect = document.getElementById("activite");
    var hourSelect = document.getElementById("heure");
    var selectedActivity = activitySelect.value;
  
    // Réinitialiser les options de l'élément "heure"
    hourSelect.innerHTML = "";
  
    // Définir les plages horaires disponibles en fonction de l'activité sélectionnée
    if (selectedActivity === "kayak" || selectedActivity === "paddle") {
      addOption(hourSelect, "10:00", "10:00 - 12:00");
      addOption(hourSelect, "12:00", "12:00 - 14:00");
      addOption(hourSelect, "14:00", "14:00 - 16:00");
      addOption(hourSelect, "16:00", "16:00 - 18:00");
    } else if (selectedActivity === "catamaran" || selectedActivity === "surf") {
      for (var i = 10; i <= 18; i++) {
        var hour = i.toString().padStart(2, '0') + ":00";
        addOption(hourSelect, hour, hour);
      }
    }
  }
  
  function addOption(selectElement, value, text) {
    var option = document.createElement("option");
    option.value = value;
    option.text = text;
    selectElement.appendChild(option);
  }
  
  // Appeler la fonction updateHours lorsque la page se charge
  window.onload = function() {
    updateHours();
  };
  
  // Appeler la fonction updateHours lorsque l'activité est modifiée
  document.getElementById("activite").addEventListener("change", updateHours);
  