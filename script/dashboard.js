const translatePreference = type => {
  switch (type) {
    case "attending": return "Ще присъствам";
    case "not_attending": return "Няма да присъствам";
    case "maybe": return "Може би";
    default: return "";
  }
};

document.addEventListener("DOMContentLoaded", async () => {
    const presentationsSection = document.getElementById("presentations-section");
    const preferencesSection = document.getElementById("preferences-section");
    const title = document.getElementById("section-title");

    document.getElementById("all-presentations-btn").addEventListener("click", () => {
      presentationsSection.style.display = "block";
      preferencesSection.style.display = "none";
      title.textContent = "Всички презентации";
    });

    document.getElementById("preferences-btn").addEventListener("click", async () => {
        presentationsSection.style.display = "none";
        preferencesSection.style.display = "block";
        title.textContent = "Моите предпочитания";

        const res = await fetch("php/api.php/loadPreferences", { method: "POST" });
        const data = await res.json();
        const tbody = document.querySelector("#preferences-table tbody");
        tbody.innerHTML = "";

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

    document.getElementById("logout-btn").addEventListener("click", async () => {
        const res = await fetch("php/api.php/logout", { method: "POST" });
        const result = await res.json();
        if (result.success) {
          window.location.href = "index.html";
        } else {
          alert("Грешка при изход: " + result.error);
        }
    });

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

        const select = tr.querySelector("select.preference");
        if (select && presentation.preferenceType) {
          select.value = presentation.preferenceType;
        }
        });

        document.querySelectorAll(".preference").forEach(select => {
          select.addEventListener("change", async (e) => {
            const title = e.target.getAttribute("data-title");
            const preferenceType = e.target.value;
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