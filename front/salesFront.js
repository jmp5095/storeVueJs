const app=new Vue({
  el:'#app',
  data:{
    showBillModal:false,
    errorMsg:'',
    successMsg:'',
    sales:[],
    bill:[],
    currentSale:{}


  },
  mounted:function(){
    this.getAllSales();
  },
  methods:{
    getAllSales:function(){
      axios.post('http://localhost/store2/back/saleBackend.php?action=read').then(function(response){
        if (!response.data.error) {
          app.sales=response.data.sales;
        }
      });
    },
    getBill:function(){
      let formData=app.toFormData(app.currentSale);
      axios.post('http://localhost/store2/back/saleBackend.php?action=readBill',formData).then(function(response){
        if (!response.data.error) {
          app.bill=response.data.bill;
          app.totalCalculate();
        }
      });
    },
    selectSale:function(sale){
      app.currentSale=sale;
    },
    toFormData:function(obj){
      let fd= new FormData();
      for (let i in obj) {
        fd.append(i,obj[i]);
      }
      return fd;
    },
    totalCalculate:function(){
      let t=0;
      for (var p of app.bill) {
        t+=p.quantity*p.price;
      }
      t=app.toFormatPesos(t)
      app.bill['total']=t;
    },
    toFormatPesos:function(pesos){
        pesos=pesos+"";
        let arr=pesos.split("");
        let aux=0;
        let fp="";

        for (let i=arr.length-1;i>=0;i--) {
          if (aux==3) {
            fp="."+fp;
            aux=0;
            i=i+1;
          }else{
            fp=arr[i]+fp;
            aux++;
          }
        }
        return fp;

    }


  }
});
