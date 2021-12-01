<!DOCTYPE html>
<html>
<body>
   <!--start of page content or body-->
   <div class="container bodycontainer">
      <div class="row">
         <div class="panel panel-primary">
            <ol class="breadcrumb">
               <?php  
                  // echo $this->breadcrumbs->show();
                  // $district=$this -> session -> District;		   
               ?>
            </ol> 
            <div class="panel-heading"> Email Form</div>
            <div class="panel-body">
               <table id="supervisor-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
                  <thead>
                     <tr>
                        <th class="text-center Heading">S#</th>                
                        <th class="text-center Heading">Name</th>
                        <th class="text-center Heading">Designation</th>
                        <th class="text-center Heading">District</th>
                        <th class="text-center Heading">Status</th>
                     </tr>
                  </thead>
                  <tbody id="tbody" style="text-align:center;">
                     <tr>
                        <td class="text-center">1</td>                
                        <td class="text-center">Nasir</td>
                        <td class="text-center">Developer</td>
                        <td class="text-center">Chakwal</td>
                        <td class="text-center">Sent</td>
                     </tr>
                     <tr>
                        <td class="text-center">2</td>                
                        <td class="text-center">Zohaib</td>
                        <td class="text-center">Developer</td>
                        <td class="text-center">Swabi</td>
                        <td class="text-center">Received</td>
                     </tr>
                     <tr>
                        <td class="text-center">3</td>                
                        <td class="text-center">Rizwan</td>
                        <td class="text-center">Developer</td>
                        <td class="text-center">Faisalabad</td>
                        <td class="text-center">Pending</td>
                     </tr>                                       
                  </tbody>
               </table>
               <div class="row bgrow"></div>
            </div> <!--end of panel body-->
         </div> <!--end of panel panel-primary-->
      </div><!--end of row-->
   </div><!--End of page content or body -->
</body>
</html>