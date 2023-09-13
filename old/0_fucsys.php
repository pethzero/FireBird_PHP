<script>
// แปลงฟังก์ชัน getStatusText เป็น Arrow Function
const getStatusText = (data) => {
  let statusText = '';
  if (data === 'A'){
    statusText = 'Active';
  } else if (data === 'C') {
    statusText = 'Cancel';
  } else if (data === 'D') {
    statusText = 'Done';
  }
  return statusText;
};

// แปลงฟังก์ชัน formatDate เป็น Arrow Function
const formatDate = (data) => {
  if (!data) {
    return ''; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
  }
  
  const dateObj = new Date(data);
  const day = dateObj.getDate();
  const month = dateObj.getMonth() + 1;
  const year = dateObj.getFullYear();
  const formattedDate = `${(month < 10 ? '0' + month : month)}/${(day < 10 ? '0' + day : day)}/${year}`;
  return formattedDate;
};

const formatCurrency = (amount) => {
  if (amount === '') {
    return '';
  }
  let formattedAmount = parseFloat(amount).toFixed(2);
  formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  formattedAmount += '฿';
  return formattedAmount;
};
const formatDecimalData  = (data) =>{
  let formattedDecimalData =parseFloat(data).toFixed(3);
  return formattedDecimalData;
};

const formatImageBlob  = (data) =>{
  if (data){return '<img src="data:image/jpeg;base64,' + data + '" width="50" height="50">';}
  else{return '<div style="width: 50px; height: 50px;"></div>';}
};

const customFocusRender = (data, type, row,datainput) => {
  if (datainput === 'focusdatahd') {
    return `<button class="btn btn-primary ${datainput}">กระโดดไปหา PM TIME</button>`;
  } else {
    return `<button class="btn btn-primary ${datainput}">กระโดดไปหา PM TIME</button>`;
  }
};

const customModelRender = (data, type, row,datainput) => {
  if (datainput === 'datahd') {
    return `<button class="btn btn-primary ${datainput}" data-bs-toggle="modal" data-bs-target="#myModal" data-bs-row-id="${row['RECNO']}">${datainput}</button>`;
  } else {
    return `<button class="btn btn-primary ${datainput}" data-bs-toggle="modal" data-bs-target="#myModal" data-bs-row-id="${row['RECNO']}">${datainput}</button>`;
  }
};

var dtcolumn = 
{
  ///////////////////////////  DATAQUOD ///////////////////////////
  'dataquoud':   [
    { data: 'RECNO' },
    // { data: null,render: function(data, type, row) {return '<button class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-row-id="' + row['RECNO'] + '">Show</button>';}},
    { data: null, render: customModelRender(data, type, row, 'show') },
    { data: 'QDOCNO' },
    { data: 'STATUS',render: getStatusText},
    { data: 'NAME' },
    { data: 'CODE' },
    { data: 'QDOCDATE',render: formatDate},
    { data: 'DELYDATE',render: formatDate},
    { data: 'NETAMT' ,render: formatCurrency},
    { data: 'EMPNAMESALES' },
    { data: 'EMPNAMEMAKER' },
    { data: 'EMPNAMEAPPROVER' },
    { data: 'REMARK' },
  ],
  'datainvent': [
    { data: 'RECNO' },
    { data: 'CODE' },
    { data: 'TYPENAME' },
    { data: 'PRODNAME'},
    { data: 'QUAN',   render: formatDecimalData},
    { data: 'COSTAMT',render: formatCurrency},
    { data: 'SALEAMT',render: formatCurrency},
    { data: 'LASTIN' ,render: formatDate},
    { data: 'LASTOUT',render: formatDate}
  ]
  ,
  'datamachine': [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row) {
        return customFocusRender(data, type, row, 'focusdatahd');
      }
    },
    { data: 'IMAGE',render: formatImageBlob},
    { data: 'STATUS'},
    { data: 'MCTYPE'},
    { data: 'MCCODE'},
    { data: 'MCNAME' },
    { data: 'CAPWEEK' },
    { data: 'MCCOSTRATE'  },
    { data: 'COSTFACTOR' },
    { data: 'DAYJOB' },
    { data: 'NIGHTJOB' }
  ],
  'datamachinepmtime': [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row) {
        return customFocusRender(data, type, row, 'focusdatahd');
      }
    },
    { data: 'IMAGE',render: formatImageBlob},
    { data: 'STATUS' },
    { data: 'MCTYPE'},
    { data: 'MCCODE',  },
    { data: 'MCNAME' },
    { data: 'CAPWEEK' },
    { data: 'MCCOSTRATE'  },
    { data: 'COSTFACTOR' },
    { data: 'DAYJOB' },
    { data: 'NIGHTJOB' }
  ]
  ///////////////////////////////////////////////////////////////////////////////////////////
};
</script>