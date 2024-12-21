.clock {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 26px;
      animation: fadeIn 3s;
    }


  <div class="clock py-5" id="clock"></div>
  <script>
    function updateClock() {
      const now = new Date();
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      const seconds = String(now.getSeconds()).padStart(2, '0');
      document.getElementById('clock').innerText = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>
