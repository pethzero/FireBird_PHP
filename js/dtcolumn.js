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

const getStatusTextOther = (data, column) => {
  // เช็คคอลัมน์ที่ต้องการแปลงค่า
  // if (column === 'STATUS') {
  //   // ทำการแปลงค่าตามต้องการ
  //   if (data === 'A') {
  //     return 'Active';
  //   } else if (data === 'C') {
  //     return 'Cancel';
  //   } else if (data === 'D') {
  //     return 'Done';
  //   }
  // }
    if (data != ''){
      return 'Active';
    }
    else{
      return 'อนุมัติแล้ว'
    }
  // ถ้าไม่ใช่คอลัมน์ 'STATUS' ให้คืนค่าเป็นตัวอักษรเดิม
  // return data;
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
    return `<button class="btn btn-primary ${datainput}">PM TIME</button>`;
  } else {
    return `<button class="btn btn-primary ${datainput}">PM TIME</button>`;
  }
};

const customModelRender = (data, type, row,idmodel,idname) => {
  // if (idmodel === 'pmtime') {
  //   return `<button class="btn btn-primary ${idmodel}" data-bs-toggle="modal" data-bs-target="#${idmodel}" data-bs-row-id="${row['RECNO']}">${idname}</button>`;
  // } else {
  //   return `<button class="btn btn-primary ${idmodel}" data-bs-toggle="modal" data-bs-target="#${idmodel}" data-bs-row-id="${row['RECNO']}">${idname}</button>`;
  // }
  return `<button class="btn btn-primary ${idmodel}" data-bs-toggle="modal" data-bs-target="#${idmodel}" data-bs-row-id="${row['RECNO']}">${idname}</button>`;
};

var dtcolumn = 
{
  ///////////////////////////  DATAQUOD ///////////////////////////
  'dataquoud':   [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row)
      {
        return customModelRender (data, type, row, 'hq','SHOW' );
      }
    },
    { data: 'QDOCNO' },
    { data: 'STATUS',
    render: function(data, type, row) {
      let text = row.EMPNAMEAPPROVER !== '' ? 'อนุมัติแล้ว' : 'รออนุมัติ';
      return text;
    },
    },
    { data: 'CODE' },
    { data: 'NAME' },
    { data: 'QDOCDATE',render: formatDate},
    { data: 'DELYDATE',render: formatDate},
    { data: 'NETAMT' ,render: formatCurrency},
    { data: 'EMPNAMESALES' },
    { data: 'EMPNAMEMAKER' },
    { data: 'EMPNAMEAPPROVER' },
    { data: 'REMARK' },
  ],
  'dataquoud_dt':
  [
  {data: 'QUOTHD'},
  {data: 'CODE'},
  {data: 'DETAIL'},
  {data: 'QUAN'},
  {data: 'UNITNAME'},
  {data: 'UNITAMT',render: formatCurrency},
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
    { data: 'MCCODE'},
    { data: 'MCNAME' },
    { data: 'MCTYPE'}
    // { data: 'CAPWEEK' },
    // { data: 'MCCOSTRATE'  },
    // { data: 'COSTFACTOR' },
    // { data: 'DAYJOB' },
    // { data: 'NIGHTJOB' }
  ],
  'datamachinepmtime': [
   { data: 'RECNO'},
   {
    data: null,
    render: function(data, type, row) {
      return customModelRender(data, type, row, 'pmtime','show');
    }
   },
   { data: 'Machine'},
   { data: 'Name'},
   { data: 'No'},
   { data: 'Interval'},
   { data: 'Document'},
   { data: 'Job'},
   { data: 'Area'},
   { data: 'Delay'},
   { data: 'Remark'}
  ]
  ///////////////////////////////////////////////////////////////////////////////////////////
};