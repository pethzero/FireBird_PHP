<script>
// Function to generate random data
    function generateRandomData()
      {
        // const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const datasets = [];
        for (let i = 0; i < Math.floor(Math.random() * 5) + 1; i++){
            const randomNumbers = generateRandomNumbers();
            const randomColors = generateRandomColors(0.2);
              
            datasets.push({
              label: `Dataset ${i + 1}`,
              data: randomNumbers,
              backgroundColor: randomColors,
              borderColor: generateRandomColors(1),
              borderWidth: 1
            });
          }
          datachart = {
          labels,
          datasets
        };

        myChart.data = datachart;
        myChart.update();
      }

      // Function to generate random numbers
      function generateRandomNumbers() {
        const randomData = [];
        // for (let i = 0; i < 7; i++) {
        for (let i = 0; i < 12; i++) {
          randomData.push(Math.floor(Math.random() * 1000000) + 1);
        }
        return randomData;
      }

      // Function to generate random colors
      function generateRandomColors(alpha) {
        const randomColors = [];
        for (let i = 0; i < 7; i++) {
        // for (let i = 0; i < 12; i++) {
          const red = Math.floor(Math.random() * 256);
          const green = Math.floor(Math.random() * 256);
          const blue = Math.floor(Math.random() * 256);
          randomColors.push(`rgba(${red}, ${green}, ${blue}, ${alpha})`);
        }
        return randomColors;
      }
</script>
