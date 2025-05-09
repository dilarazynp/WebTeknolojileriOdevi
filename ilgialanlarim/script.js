document.addEventListener('DOMContentLoaded', function () {
    const filmler = [
      { ad: "The Fall", yil: "2006" },
      { ad: "The Prestige", yil: "2006" },
      { ad: "V for Vendetta", yil: "2005" }
    ];
  
    filmler.forEach(film => {
      filmGoster(film.ad, film.yil);
    });
  });
  
  async function filmGoster(filmAdi, filmYili) {
    const apiKey = "d6c6992f";
    const url = `https://www.omdbapi.com/?apikey=${apiKey}&t=${encodeURIComponent(filmAdi)}&y=${filmYili}`;
  
    try {
      const response = await fetch(url);
      const film = await response.json();
  
      if (film.Response === "True") {
        document.getElementById("filmList").innerHTML += `
          <div class="card shadow mb-5">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="${film.Poster}" alt="${film.Title}" class="img-fluid rounded-start">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">${film.Title} (${film.Year})</h5>
                  <p class="card-text"><strong>Tür:</strong> ${film.Genre}</p>
                  <p class="card-text"><strong>Yönetmen:</strong> ${film.Director}</p>
                  <p class="card-text"><strong>Oyuncular:</strong> ${film.Actors}</p>
                  <p class="card-text"><strong>Konu:</strong> ${film.Plot}</p>
                  <p class="card-text"><small class="text-muted">IMDb: ${film.imdbRating}</small></p>
                </div>
              </div>
            </div>
          </div>`;
      } else {
        document.getElementById("filmList").innerHTML += `<div class="alert alert-warning">Film bulunamadı: ${filmAdi}</div>`;
      }
    } catch (err) {
      document.getElementById("filmList").innerHTML += `<div class="alert alert-danger">Hata: ${err.message}</div>`;
    }
  }
  