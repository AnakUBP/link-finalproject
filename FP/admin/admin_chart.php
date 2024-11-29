<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendapatan</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
  .row {
    display: flex;
    flex-wrap: wrap;
    /* Membungkus elemen jika layar sempit */
    justify-content: space-between;
    align-items: flex-start;
  }

  .col-md-6,
  .chart-box {
    margin-bottom: 20px;
    width: 48%;
    /* Default 48% untuk layar besar */
  }

  .col-md-12 {
    margin-top: 30px;
    width: 100%;
    /* Lebar penuh untuk elemen tunggal */
  }

  h4 {
    margin-bottom: 20px;
    text-align: center;
    /* Heading rata tengah */
  }

  canvas {
    display: block;
    max-width: 100%;
    /* Membatasi lebar */
    height: auto;
    /* Tinggi menyesuaikan */
    margin: 0 auto;
    /* Tengah */
  }

  .charts-container {
    display: flex;
    flex-wrap: wrap;
    /* Bungkus elemen jika ruang tidak cukup */
    gap: 30px;
    /* Jarak antar elemen */
  }

  @media (max-width: 768px) {

    .row,
    .charts-container {
      flex-direction: column;
      /* Elemen vertikal */
      align-items: stretch;
      /* Lebar penuh */
      gap: 20px;
      /* Kurangi jarak antar elemen */
    }

    .chart-box,
    .col-md-6 {
      width: 100%;
      /* Lebar penuh untuk layar kecil */
      margin-bottom: 20px;
    }
  }

  .informasi {
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.3);
    border-radius: 8px;
    /* Tambahkan jika ingin sudut membulat */
  }
  </style>
  <script>
  // Contoh untuk Chart Bulanan
  var monthlyCtx = document.getElementById('incomeChartMonthly').getContext('2d');
  var incomeChartMonthly = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($months); ?>, // Nama bulan
      datasets: [{
        label: 'Pendapatan Bulanan',
        data: <?php echo json_encode($totals_monthly); ?>, // Pendapatan per bulan
        backgroundColor: '#4caf50',
        borderColor: '#388e3c',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true, // Aktifkan responsivitas
      maintainAspectRatio: false, // Jangan pertahankan rasio aspek
      plugins: {
        legend: {
          display: true,
          position: 'top'
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Bulan'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Pendapatan (Rp)'
          },
          beginAtZero: true
        }
      }
    }
  });
  </script>
</head>

<body>
  <div class="container-fluid">
    <div class="col-md-6 alert-info p-4 informasi">
      <h6 class="text-success">
        <strong>Pendapatan Terbesar:<br></strong> Rp <?= number_format($max_income, 0, ',', '.') ?>
        pada <?= $max_income_date_formatted ?>.
      </h6>
      <h6 class="text-primary">
        <strong>Pendapatan Terkecil:<br></strong> Rp <?= number_format($min_income, 0, ',', '.') ?>
        pada <?= $min_income_date_formatted ?>.
      </h6>
      <hr class="bg-dark">
      <h6>
        <strong>Rata-rata Durasi Reservasi:<br></strong>
        <?= $avg_duration ?> menit pada studio <?= $avg_studio ?>.
      </h6>
      <h6>
        <strong>User dengan Reservasi Terbanyak:<br></strong>
        <?= $max_user ?>.
      </h6>
      <h6>
        <strong>User dengan Reservasi Tersedikit:<br></strong>
        <?= $min_user ?>.
      </h6>
    </div>
  </div>

  <div class="container-fluid mt-3">
    <!-- Baris Pertama: Pendapatan Harian dan Bulanan -->
    <div class="row">
      <div class="col-md-6">
        <h4 class="text-center">Pendapatan Harian Pada Bulan</h4>
        <div id="calendar"></div>
      </div>
      <div class="col-md-6">
        <h4 class="text-center">Pendapatan Bulanan Tahun <?= $selected_year ?></h4>
        <form method="GET" id="yearForm">
          <center>
            <select class="btn alert-primary" name="year" id="yearSelect"
              onchange="document.getElementById('yearForm').submit();">
              <?php foreach ($available_years as $year): ?>
              <option value="<?= $year ?>" <?= $year == $selected_year ? 'selected' : '' ?>><?= $year ?></option>
              <?php endforeach; ?>
            </select>
          </center>
        </form>
        <canvas id="incomeChartMonthly" width="600" height="400"></canvas>
      </div>
    </div>

    <!-- Baris Kedua: Pendapatan Tahunan dan Perbandingan Reservasi Studio -->
    <div class="row mt-2">
      <div class="col-md-6">
        <h4 class="text-center">Pendapatan Tahunan</h4>
        <canvas id="incomeChartYearly" width="600" height="400"></canvas>
      </div>
      <div class="col-md-6">
        <h4 class="text-center">Perbandingan Reservasi per Studio</h4>
        <canvas id="studioPieChart" width="400" height="400"></canvas>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    // Data pendapatan harian dari PHP (mengubah data PHP menjadi format JSON)
    const dailyIncome = <?php echo json_encode($daily_income); ?>;

    // Inisialisasi kalender
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      events: function(start, end, timezone, callback) {
        const events = [];

        // Mengisi event kalender dengan pendapatan per tanggal
        for (const [date, income] of Object.entries(dailyIncome)) {
          events.push({
            title: '' + income.toLocaleString('id-ID'),
            start: date,
            allDay: true,
            color: '#4CAF50',
            textColor: 'white'
          });
        }

        // Mengembalikan events
        callback(events);
      },
      dayRender: function(date, cell) {
        const dateString = date.format('YYYY-MM-DD');
        if (dailyIncome[dateString]) {
          const income = dailyIncome[dateString];
        }
      }
    });
  });

  // Membuat Pie Chart
  var ctx = document.getElementById('studioPieChart').getContext('2d');
  var studioPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode($studio_names); ?>, // Nama studio
      datasets: [{
        label: 'Jumlah Reservasi',
        data: <?php echo json_encode($reservation_counts); ?>, // Jumlah reservasi
        backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#ff6347', '#4caf50', '#f44336'],
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        tooltip: {
          callbacks: {
            label: function(tooltipItem) {
              return tooltipItem.label + ': ' + tooltipItem.raw + ' reservasi';
            }
          }
        }
      }
    }
  });

  // Data untuk chart pendapatan bulanan
  var monthlyCtx = document.getElementById('incomeChartMonthly').getContext('2d');
  var incomeChartMonthly = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($months); ?>, // Nama bulan
      datasets: [{
        label: 'Pendapatan Bulanan',
        data: <?php echo json_encode($totals_monthly); ?>, // Pendapatan per bulan
        backgroundColor: '#4caf50',
        borderColor: '#388e3c',
        borderWidth: 1
      }]
    }
  });

  // Data untuk chart pendapatan tahunan
  var yearlyCtx = document.getElementById('incomeChartYearly').getContext('2d');
  var incomeChartYearly = new Chart(yearlyCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($years); ?>, // Nama tahun
      datasets: [{
        label: 'Pendapatan Tahunan',
        data: <?php echo json_encode($totals_yearly); ?>, // Pendapatan per tahun
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: '#4bc0c0',
        borderWidth: 1
      }]
    }
  });
  </script>
</body>

</html>