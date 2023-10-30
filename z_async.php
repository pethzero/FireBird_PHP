async function fetchData() {
  try {
    const response = await fetch('https://api.example.com/data'); // เปลี่ยน URL เป็น URL ที่คุณต้องการเรียกใช้
    
    if (!response.ok) {
      throw new Error('ไม่สามารถดึงข้อมูลได้');
    }

    const data = await response.json();
    console.log(data); // แสดงข้อมูลที่ได้รับในคอนโซล
  } catch (error) {
    console.error('เกิดข้อผิดพลาด: ', error);
  }
}

fetchData();