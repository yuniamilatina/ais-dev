<script type="text/javascript" src="<?php echo base_url();?>assets/js/tablemaster.js" ></script>
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Laporan Produksi Harian</strong></a></li>
        </ol>
    </section>

    <section class="content" >
      <div class="row" >
        <div class="col-md-12 text-center" >
          <div class="grid">
            <div class="grid-header">
              <div class="panel panel-default">
                <div class="panel-heading"><strong>Laporan Produksi Harian</strong></div>
              </div>
            </div>
            <div class="grid-body">
       <!--        <form method="POST" action="<?= base_url() ?>index.php/pes/kanban_master/mj_box"> -->
            <div style="overflow-x:scroll; overflow-y: hidden" class="vcenter">
              <table class="table table-bordered" width="1500px" id="dataTables1">
                <thead>
                  <tr>
                    <th>Prod. Line</th>
                    <th>Back No</th>
                    <th>Material No</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th>UOM</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                    <th>19</th>
                    <th>20</th>
                    <th>21</th>
                    <th>22</th>
                    <th>23</th>
                    <th>24</th>
                    <th>25</th>
                    <th>26</th>
                    <th>27</th>
                    <th>28</th>
                    <th>29</th>
                    <th>30</th>
                    <th>31</th>
                    <th>Total</th>
                    <th>Average</th>
                  </tr>
                </thead>
                <tbody>
                  <?php   
                  foreach ($table as $show) {
                   ?>
                   <tr>

                    <?php  ?>

                    <td><input type="text" name="MDV01[]" value="<?php echo $show['MDV01']; ?>" style="width: 100px;" class="form-control" readonly></td>
                    <td><input type="text" name="ZEINR[]" value="<?php echo $show['ZEINR']; ?>" style="width: 80px;" readonly class="form-control" > </td>
                    <td><input type="text" name="MATNR[]" value="<?php echo $show['MATNR'];?>" style="width: 130px;" readonly class="form-control" ></td>
                    <td><input type="text" name="MAKTX[]" value="<?php echo $show['MAKTX']; ?>" style="width: 100px;" readonly class="form-control" ></td>
                    <td><input type="text" name="PLNMG[]" value="<?php echo $show['PLNMG'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="MEINS[]" value="<?php echo $show['MEINS']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY01[]" value="<?php echo $show['QTY01']; ?>" style="width: 60px;" class="form-control" readonly></td>
                    <td><input type="text" name="QTY02[]" value="<?php echo $show['QTY02']; ?>" style="width: 60px;" readonly class="form-control" > </td>
                    <td><input type="text" name="QTY03[]" value="<?php echo $show['QTY03'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY04[]" value="<?php echo $show['QTY04']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY05[]" value="<?php echo $show['QTY05'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY06[]" value="<?php echo $show['QTY06']; ?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY07[]" value="<?php echo $show['QTY07'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY08[]" value="<?php echo $show['QTY08']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY09[]" value="<?php echo $show['QTY09'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY10[]" value="<?php echo $show['QTY10']; ?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY11[]" value="<?php echo $show['QTY11']; ?>" style="width: 60px;" class="form-control" readonly></td>
                    <td><input type="text" name="QTY12[]" value="<?php echo $show['QTY12']; ?>" style="width: 60px;" readonly class="form-control" > </td>
                    <td><input type="text" name="QTY13[]" value="<?php echo $show['QTY13'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY14[]" value="<?php echo $show['QTY14']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY15[]" value="<?php echo $show['QTY15'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY16[]" value="<?php echo $show['QTY16']; ?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY17[]" value="<?php echo $show['QTY17'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY18[]" value="<?php echo $show['QTY18']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY19[]" value="<?php echo $show['QTY19'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY20[]" value="<?php echo $show['QTY20']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY21[]" value="<?php echo $show['QTY21']; ?>" style="width: 60px;" class="form-control" readonly></td>
                    <td><input type="text" name="QTY22[]" value="<?php echo $show['QTY22']; ?>" style="width: 60px;" readonly class="form-control" > </td>
                    <td><input type="text" name="QTY23[]" value="<?php echo $show['QTY23'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY24[]" value="<?php echo $show['QTY24']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY25[]" value="<?php echo $show['QTY25'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY26[]" value="<?php echo $show['QTY26']; ?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY27[]" value="<?php echo $show['QTY27'];?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY28[]" value="<?php echo $show['QTY28']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="QTY29[]" value="<?php echo $show['QTY29'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY30[]" value="<?php echo $show['QTY30']; ?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="QTY31[]" value="<?php echo $show['QTY31']; ?>" style="width: 60px;" readonly class="form-control" ></td>
                    <td><input type="text" name="TOTAL[]" value="<?php echo $show['TOTAL'];?>" style="width: 60px;" readonly class="form-control"  ></td>
                    <td><input type="text" name="AVERA[]" value="<?php echo number_format($show['AVERA'],3,",",".") ; ?>" style="width: 75px;" readonly class="form-control"  ></td>
                   

                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
              <!-- </form> -->
            </div>
            <!-- end grid body -->
          </div>
          <!-- end grid class  -->
        </div>  
      </div>
    </section>
</aside>

