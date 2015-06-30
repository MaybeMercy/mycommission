### Commission  

##### About

一个简单的C/S架构的网站，使用用户为管理员和销售人员。

一个商人销售枪支，但是也可以将枪支分成locks, stocks, barrels分别进行销售。商人会雇佣销售人员进行销售，然后会按月付给他们佣金。

##### Users

销售人员登录网站后填写相应的销售项目以及数量，点击commit提交项目，点击commit -1之后表示本月不再进行销售活动，销售项目分为locks, stocks, barrels, 价格分别是45$, 30$, $25, 销售人员至少完整卖出一套枪支的配件才能获得佣金。

管理人员登录后可以选择销售人员进行查看他的销售业绩，并且可以根据销售数量计算出本月的支付金额。

##### Dependence 

* PHP5.4
* Sqlite数据库
* [Bootstrap](http://v3.bootcss.com/)
* [ECharts](http://echarts.baidu.com/)

