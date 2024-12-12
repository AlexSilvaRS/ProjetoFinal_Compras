async function getWeather() {
    const city = document.getElementById('city').value;
    const apiKey = '8184d08966e562136b48521d0ef789e5'; // Coloque sua chave de API aqui
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric&lang=pt_br`;
  
    try {
        const response = await fetch(url);
        const data = await response.json();
  
        document.getElementById('city-name').innerText = `Clima em ${data.name}`;
        document.getElementById('temperature').innerText = `Temperatura: ${data.main.temp}°C`;
        document.getElementById('description').innerText = `Descrição: ${data.weather[0].description}`;
        document.getElementById('humidity').innerText = `Umidade: ${data.main.humidity}%`;
        document.getElementById('wind-speed').innerText = `Velocidade do vento: ${data.wind.speed} km/h`;
    } catch (error) {
        alert("Cidade não encontrada, tente novamente.");
    }
  }