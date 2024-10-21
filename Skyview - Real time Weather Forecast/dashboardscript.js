// Fetch weather data based on user's current location
window.onload = function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            fetchWeatherByCoords(lat, lon);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
};

// Fetch weather using coordinates (for current location)
function fetchWeatherByCoords(lat, lon) {
    const apiKey = ''; // Replace with your OpenWeatherMap API Key
    const weatherAPI = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;

    fetch(weatherAPI)
        .then(response => response.json())
        .then(data => {
            if (data.cod === 200) {
                // Extract weather information
                const temperature = data.main.temp;
                const weatherStatus = data.weather[0].main;
                const icon = data.weather[0].icon;
                const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

                // Update UI
                document.getElementById('location').textContent = data.name;
                document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
                document.getElementById('weather-status').textContent = weatherStatus;
                document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
                document.getElementById('datetime').textContent = dateTime;
            } else {
                alert("Unable to fetch weather data for current location.");
            }
        })
        .catch(error => {
            console.error("Error fetching the weather data", error);
        });
}

// Fetch weather based on the searched city
document.getElementById('search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const location = document.getElementById('search-input').value;
    fetchWeatherByLocation(location);
});

// Fetch weather using the city name (for searched locations)
function fetchWeatherByLocation(location) {
    const apiKey = ''; // Replace with your OpenWeatherMap API Key
    const weatherAPI = `https://api.openweathermap.org/data/2.5/weather?q=${location}&units=metric&appid=${apiKey}`;

    fetch(weatherAPI)
        .then(response => response.json())
        .then(data => {
            if (data.cod === 200) {
                // Extract weather information
                const temperature = data.main.temp;
                const weatherStatus = data.weather[0].main;
                const icon = data.weather[0].icon;
                const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

                // Update UI
                document.getElementById('location').textContent = data.name;
                document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
                document.getElementById('weather-status').textContent = weatherStatus;
                document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
                document.getElementById('datetime').textContent = dateTime;
            } else {
                alert(`Error: ${data.message}`);  // Show the error message returned by the API
            }
        })
        .catch(error => {
            console.error("Error fetching the weather data", error);
            alert("Something went wrong. Please try again.");
        });
}

// Function to fetch weather data for the current location on page load
async function getCurrentLocationWeather() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async (position) => {
            const { latitude, longitude } = position.coords;
            const apiKey = ''; // Replace with your OpenWeatherMap API Key
            const response = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric`);
            if (!response.ok) {
                console.error('Error fetching weather data:', response.statusText);
                return;
            }
            const data = await response.json();
            updateDashboard(data);
        }, (error) => {
            console.error('Error getting location:', error);
        });
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}

// Function to update the dashboard
function updateDashboard(data) {
    document.getElementById('location').innerText = data.city.name;
    document.getElementById('temperature').innerText = `${Math.round(data.list[0].main.temp)}°C`;
    document.getElementById('weather-status').innerText = data.list[0].weather[0].description;
    document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${data.list[0].weather[0].icon}.png`;
}

// Function to fetch and update hourly forecast for next 24 hours
function updateHourlyForecast(data) {
const hourlyWeatherContainer = document.querySelector('.hourly-forecast');
hourlyWeatherContainer.innerHTML = ''; // Clear previous forecast

// Filter data for the next 24 hours (3-hour intervals, 8 entries)
const hourlyData = data.list.slice(0, 12); // 8 entries for 24 hours

hourlyData.forEach(hour => {
const hourElement = document.createElement('div');
hourElement.classList.add('hour');

// Format time
const time = new Date(hour.dt * 1000).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
const temp = Math.round(hour.main.temp);
const icon = hour.weather[0].icon;
const weatherDescription = hour.weather[0].description;

// Create the hourly forecast element
hourElement.innerHTML = `
    <span>${time}</span>
    <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="weather icon">
    <span>${temp}°C</span>
    <p>${weatherDescription}</p>
`;

// Append each hour's forecast to the container
hourlyWeatherContainer.appendChild(hourElement);
});
}

// Function to fetch weather data based on coordinates (including hourly forecast)
function fetchWeatherByCoords(lat, lon) {
const apiKey = '';  // Replace with your OpenWeatherMap API Key
const weatherAPI = `https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;

fetch(weatherAPI)
.then(response => response.json())
.then(data => {
    if (data.cod === "200") {
        // Extract and update the current weather
        const temperature = data.list[0].main.temp;
        const weatherStatus = data.list[0].weather[0].main;
        const icon = data.list[0].weather[0].icon;
        const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

        document.getElementById('location').textContent = data.city.name;
        document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
        document.getElementById('weather-status').textContent = weatherStatus;
        document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
        document.getElementById('datetime').textContent = dateTime;

        // Update hourly forecast
        updateHourlyForecast(data);
    } else {
        alert("Unable to fetch weather data for current location.");
    }
})
.catch(error => {
    console.error("Error fetching the weather data", error);
});
}

// Function to fetch weather data based on city name (for searched locations)
function fetchWeatherByLocation(location) {
const apiKey = '';  // Replace with your OpenWeatherMap API Key
const weatherAPI = `https://api.openweathermap.org/data/2.5/forecast?q=${location}&units=metric&appid=${apiKey}`;

fetch(weatherAPI)
.then(response => response.json())
.then(data => {
    if (data.cod === "200") {
        // Extract and update the current weather
        const temperature = data.list[0].main.temp;
        const weatherStatus = data.list[0].weather[0].main;
        const icon = data.list[0].weather[0].icon;
        const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

        document.getElementById('location').textContent = data.city.name;
        document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
        document.getElementById('weather-status').textContent = weatherStatus;
        document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
        document.getElementById('datetime').textContent = dateTime;

        // Update hourly forecast
        updateHourlyForecast(data);
    } else {
        alert(`Error: ${data.message}`);
    }
})
.catch(error => {
    console.error("Error fetching the weather data", error);
    alert("Something went wrong. Please try again.");
});
}

// Function to update the 5-day forecast
function updateFiveDayForecast(data) {
    const dailyWeatherContainer = document.querySelector('.five-day-forecast');
    dailyWeatherContainer.innerHTML = ''; // Clear previous forecast

    // Filter data for daily forecasts (we get 8 entries per day in 3-hour intervals)
    const dailyData = data.list.filter(item => item.dt_txt.includes("12:00:00")); // Get weather for 12:00 PM each day

    dailyData.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.classList.add('day');

        // Format date
        const date = new Date(day.dt * 1000).toLocaleDateString([], { weekday: 'long', month: 'short', day: 'numeric' });
        const tempDay = Math.round(day.main.temp);
        const icon = day.weather[0].icon;
        const weatherDescription = day.weather[0].description;

        // Create the daily forecast element
        dayElement.innerHTML = `
            <span>${date}</span>
            <img src="https://openweathermap.org/img/wn/${icon}@2x.png" alt="weather icon">
            <span>${tempDay}°C</span>
            <p>${weatherDescription}</p>
        `;

        // Append each day's forecast to the container
        dailyWeatherContainer.appendChild(dayElement);
    });
}

// Updated fetchWeatherByCoords function to include 5-day forecast
function fetchWeatherByCoords(lat, lon) {
    const apiKey = '';  // Replace with your OpenWeatherMap API Key
    const weatherAPI = `https://api.openweathermap.org/data/2.5/forecast?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;

    fetch(weatherAPI)
    .then(response => response.json())
    .then(data => {
        if (data.cod === "200") {
            // Extract and update the current weather
            const temperature = data.list[0].main.temp;
            const weatherStatus = data.list[0].weather[0].main;
            const icon = data.list[0].weather[0].icon;
            const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

            document.getElementById('location').textContent = data.city.name;
            document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
            document.getElementById('weather-status').textContent = weatherStatus;
            document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
            document.getElementById('datetime').textContent = dateTime;

            // Update hourly forecast
            updateHourlyForecast(data);

            // Update 5-day forecast
            updateFiveDayForecast(data);
        } else {
            alert("Unable to fetch weather data for current location.");
        }
    })
    .catch(error => {
        console.error("Error fetching the weather data", error);
    });
}

// Updated fetchWeatherByLocation function to include 5-day forecast
function fetchWeatherByLocation(location) {
    const apiKey = '';  // Replace with your OpenWeatherMap API Key
    const weatherAPI = `https://api.openweathermap.org/data/2.5/forecast?q=${location}&units=metric&appid=${apiKey}`;

    fetch(weatherAPI)
    .then(response => response.json())
    .then(data => {
        if (data.cod === "200") {
            // Extract and update the current weather
            const temperature = data.list[0].main.temp;
            const weatherStatus = data.list[0].weather[0].main;
            const icon = data.list[0].weather[0].icon;
            const dateTime = new Date().toLocaleString('en-US', { weekday: 'long', hour: 'numeric', minute: 'numeric' });

            document.getElementById('location').textContent = data.city.name;
            document.getElementById('temperature').textContent = `${temperature.toFixed(1)}°C`;
            document.getElementById('weather-status').textContent = weatherStatus;
            document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${icon}@2x.png`;
            document.getElementById('datetime').textContent = dateTime;

            // Update hourly forecast
            updateHourlyForecast(data);

            // Update 5-day forecast
            updateFiveDayForecast(data);
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Error fetching the weather data", error);
        alert("Something went wrong. Please try again.");
    });
}





