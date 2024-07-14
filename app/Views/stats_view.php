<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediconnect Admin Dashboard</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="<?= base_url('assets/js/chartsJS.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/xlsx.full.min.js"></script>
</body>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <div class="user">
                                <img src="imgs/assistance.png" alt="">
                            </div>
                        </span>
                        <span class="title">MediConnect</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('manage-users') ?>">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('applications_view') ?>">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">User Applications</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('stats') ?>">
                        <span class="icon">
                            <ion-icon name="stats-chart-outline"></ion-icon>
                        </span>
                        <span class="title">Stats</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/profile') ?>">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->
                <div class="user">
                    <img src="imgs/admin.png" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <a href="<?= base_url('view-doctors') ?>">
                    <div class="card">
                        <div>
                            <div class="numbers">Doctors</div>
                            <div class="cardName">View Doctors</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="medkit-outline"></ion-icon>
                        </div>
                    </div>
                </a>
                <a href="<?= base_url('view-nurses') ?>">
                    <div class="card">
                        <div>
                            <div class="numbers">Nurses</div>
                            <div class="cardName">View Nurses</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="heart-outline"></ion-icon>
                        </div>
                    </div>
                </a>
                <a href="<?= base_url('view-patients') ?>">
                    <div class="card">
                        <div>
                            <div class="numbers">Patients</div>
                            <div class="cardName">View Patients</div>
                        </div>
                        <div class="iconBx">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ================ Charts ================= -->
            <div class="chartsBx">
                <div class="chart">
                    <canvas id="chart-1"></canvas>
                    <button id="download-pdf-1">Download as PDF</button>
                    <button id="download-excel-1">Download as Excel</button>
                    <!-- <button id="download-csv-1">Download as CSV</button> -->
                </div>
                <div class="chart">
                    <canvas id="chart-2"></canvas>
                    <button id="download-pdf-2">Download as PDF</button>
                    <button id="download-excel-2">Download as Excel</button>
                    <!-- <button id="download-csv-2">Download as CSV</button> -->
                </div>
            </div>

            <script>
                // Data from the server
                const doctorCount = <?= $doctor_count ?>;
                const nurseCount = <?= $nurse_count ?>;
                const patientCount = <?= $patient_count ?>;

                // Pie Chart
                const ctx1 = document.getElementById('chart-1').getContext('2d');
                const pieChart = new Chart(ctx1, {
                    type: 'pie',
                    data: {
                        labels: ['Doctors', 'Nurses', 'Patients'],
                        datasets: [{
                            label: '# of People',
                            data: [doctorCount, nurseCount, patientCount],
                            backgroundColor: ['#C6D8FF', '#FC7643', '#DAFF7D']
                        }]
                    },
                    plugins: [ChartDataLabels],
                    options: {
                        plugins: {
                            datalabels: {
                                color: 'black',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value, ctx) => {
                                    let datasets = ctx.chart.data.datasets;

                                    if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                        let percentage = Math.round((value / sum) * 100) + '%';
                                        let type = datasets[0].label;
                                        return value + ' (' + percentage + ')';
                                    } else {
                                        return value + ' (' + percentage + ') ';
                                    }
                                }
                            }
                        }
                    }
                });

                // Bar Chart
                const ctx2 = document.getElementById('chart-2').getContext('2d');
                const barChart = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: ['Doctors', 'Nurses', 'Patients'],
                        datasets: [{
                            label: 'Mediconnect Users',
                            data: [doctorCount, nurseCount, patientCount],
                            backgroundColor: ['#C6D8FF', '#FC7643', '#DAFF7D']
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1 // Ensure the y-axis displays integers only
                                }
                            }
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'end',
                                color: 'black',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value) => value
                            }
                        }
                    }
                });

                // Function to download chart as PDF
                function downloadChartAsPDF(chartId, fileName) {
                    const { jsPDF } = window.jspdf;
                    const canvas = document.getElementById(chartId);
                    const imgData = canvas.toDataURL('image/png');
                    const pdf = new jsPDF();
                    pdf.addImage(imgData, 'PNG', 10, 10);
                    pdf.save(fileName);
                }

                // Function to download chart data as Excel
                function downloadChartAsExcel(chart, fileName) {
                    const labels = chart.data.labels;
                    const data = chart.data.datasets[0].data;
                    const ws_data = [labels, data];
                    const ws = XLSX.utils.aoa_to_sheet(ws_data);
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                    XLSX.writeFile(wb, fileName);
                }

                // Function to download chart data as CSV
                function downloadChartAsCSV(chart, fileName) {
                    const labels = chart.data.labels.join(',');
                    const data = chart.data.datasets[0].data.join(',');
                    const csvContent = "data:text/csv;charset=utf-8," + labels + "\n" + data;
                    const encodedUri = encodeURI(csvContent);
                    const link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", fileName);
                    document.body.appendChild(link); // Required for FF
                    link.click();
                }

                document.getElementById('download-pdf-1').addEventListener('click', function () {
                    downloadChartAsPDF('chart-1', 'chart-1.pdf');
                });
                document.getElementById('download-excel-1').addEventListener('click', function () {
                    downloadChartAsExcel(pieChart, 'chart-1.xlsx');
                });
                document.getElementById('download-csv-1').addEventListener('click', function () {
                    downloadChartAsCSV(pieChart, 'chart-1.csv');
                });

                document.getElementById('download-pdf-2').addEventListener('click', function () {
                    downloadChartAsPDF('chart-2', 'chart-2.pdf');
                });
                document.getElementById('download-excel-2').addEventListener('click', function () {
                    downloadChartAsExcel(barChart, 'chart-2.xlsx');
                });
                document.getElementById('download-csv-2').addEventListener('click', function () {
                    downloadChartAsCSV(barChart, 'chart-2.csv');
                });
            </script>

            <!-- =========== Scripts =========  -->
            <script src="js/main.js"></script>

            <!-- ======= Charts JS ====== -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
            <script src="assets/js/chartsJS.js"></script>

            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        </div>
    </div>
</body>

</html>
