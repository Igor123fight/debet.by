axios.post("https://debetby.bitrix24.ru/rest/1/xv60sphb5cxdcuzz/crm.lead.add.json",
params={
    "fields": [{"OPPORTUNITY": "10000", "TITLE": "TEST"}]
    }
  )
  comsole.log(Document.GetelementbyName(EMAIL)) 
  .then(function (response) {
  console.log(response);
  })
  .catch(function (error) {
  console.log(error);
  })