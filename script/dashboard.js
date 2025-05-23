// Превежда стойностите на предпочитанията от английски на български
const translatePreference = type => {
  switch (type) {
    case "attending": return "Ще присъствам";
    case "not_attending": return "Няма да присъствам";
    case "maybe": return "Може би";
    default: return "";
  }
};

// Основната логика се изпълнява след зареждане на страницата
document.addEventListener("DOMContentLoaded", async () => {

    // Взимат се HTML елементите за двете секции и заглавието
    const presentationsSection = document.getElementById("presentations-section");
    const preferencesSection = document.getElementById("preferences-section");
    const title = document.getElementById("section-title");

    // Превключване към изглед "Всички презентации"
    document.getElementById("all-presentations-btn").addEventListener("click", () => {
      presentationsSection.style.display = "block";
      preferencesSection.style.display = "none";
      title.textContent = "Всички презентации";
    });

    // Превключване към изглед "Моите предпочитания" и зареждане на предпочитанията от сървъра
    document.getElementById("preferences-btn").addEventListener("click", async () => {
        presentationsSection.style.display = "none";
        preferencesSection.style.display = "block";
        title.textContent = "Моите предпочитания";

        // Извиква се API заявка към сървъра за зареждане на предпочитания
        const res = await fetch("php/api.php/loadPreferences", { method: "POST" });
        const data = await res.json();
        const tbody = document.querySelector("#preferences-table tbody");
        tbody.innerHTML = "";

        // Ако заявката е успешна, се показват предпочитанията
        if (data.success) {
          data.data.forEach(pref => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${pref.title}</td>
              <td>${pref.date}</td>
              <td>${translatePreference(pref.preferenceType)}</td>
            `;
            tbody.appendChild(tr);
          });
        } else {
          alert("Грешка при зареждане на предпочитания: " + data.error);
        }
    });

    // Бутон за изход от системата - извиква API и пренасочва към началната страница
    document.getElementById("logout-btn").addEventListener("click", async () => {
        const res = await fetch("php/api.php/logout", { method: "POST" });
        const result = await res.json();
        if (result.success) {
          window.location.href = "index.html";
        } else {
          alert("Грешка при изход: " + result.error);
        }
    });

    // Зарежда се началната информация за всички презентации
    const response = await fetch("php/api.php/loadDashboard", { method: "POST" });
    const result = await response.json();

    if (result.success) {
      const tbody = document.querySelector("#presentation-table tbody");
      result.data.forEach(presentation => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${presentation.title}</td>
          <td>${presentation.presenterName}</td>
          <td>${presentation.facultyNumber}</td>
          <td>${presentation.date}</td>
          <td>${presentation.place}</td>
          <td>
            <select data-title="${presentation.title}" class="preference">
              <option value="empty">Избери</option>
              <option value="attending">Ще присъствам</option>
              <option value="not_attending">Няма да присъствам</option>
              <option value="maybe">Може би</option>
            </select>
          </td>
        `;
        tbody.appendChild(tr);

        // Ако вече има избрано предпочитание, то се показва
        const select = tr.querySelector("select.preference");
        if (select && presentation.preferenceType) {
          select.value = presentation.preferenceType;
        }
        });

        // Добавяне на слушател за всяка селекция за предпочитания
        document.querySelectorAll(".preference").forEach(select => {
          select.addEventListener("change", async (e) => {
            const title = e.target.getAttribute("data-title");
            const preferenceType = e.target.value;
            
            // Изпращане на избраното предпочитание към сървъра
            const response = await fetch("php/api.php/setPreference", {
              method: "POST",
              headers: { "Content-Type": "application/x-www-form-urlencoded" },
              body: `formData=${JSON.stringify({ title, preferenceType })}`
            });
            const res = await response.json();
            if (!res.success) alert("Грешка при запис: " + res.error);

            // Презареждане на предпочитанията ако секцията е активна
            const preferencesVisible = document.getElementById("preferences-section").style.display !== "none";
            if (preferencesVisible) document.getElementById("preferences-btn").click();
          });
        });

      } else {
        alert("Грешка: " + result.error);
      }
});