<?php include('template/head.php'); ?>
<form action="action/newmembership.php" method="POST">
            <div class="main">

                <div class="heading">MEMBERSHIP FORM</div>

                 <div class="titles">Account No.</div>
                  <div class="inputs">  <input type="text" name="account_no" required=""/></div>

                    <div class="titles"> Name of Applicant</div>
                   <div class="inputs"> <input type="text" name="member_name" required=""/></div>

                    <div class="titles">Age</div>
                    <div class="inputs"><input type="text" name="member_age" required=""/></div>

                    <div class="titles">Name of Father's / Husband's</div>
                    <div class="inputs"><input type="text" name="father_name" required=""/></div>

                    <div class="titles">Present Address</div>
                    <div class="inputs"><textarea name="present_address" required=""></textarea></div>
                
                    <div class="titles">Pincode</div>
                   <div class="inputs"> <input type="text" name="present_pincode" required=""/></div>
                
                    <div class="titles">Permanent Address</div>
                    <div class="inputs"><textarea name="permanent_address" required=""></textarea></div>
                
                    <div class="titles">Pincode</div>
                    <div class="inputs"><input type="text" name="permanent_pincode" required=""/></div>
                
                    <div class="titles">Instalment(in Rs)</div>
                    <div class="inputs"><input type="text" name="instalment" required=""/></div>
                
                    <div class="titles">Mode of Deposit</div>
                       <div class="inputs"> <select name="mode">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option> 
                        </select> </div>
                
                        <div class="titles">Period</div>
                        <div class="inputs"><select name="period">
                            <option value="12">12 months</option>
                            <option value="24">24 months</option>
                            <option value="36">36 months</option> 
                        </select></div>
                
                         <div class="titles">Occupation</div>
                       <div class="inputs"> <input type="radio" name="occupation" value="service"/> Service
                         <input type="radio" name="occupation" value="business" /> Business </div>
                
                    <div class="titles">Phone</div>
                    <div class="input"><input type="text" name="member_phone" required=""/></div>

                    <div class="titles">Name of Nominee</div>
                    <div class="inputs"><input type="text" name="nominee_name" required=""/></div>
                
                    <div class="titles">Age</div>
                   <div class="inputs"> <input type="text" name="nominee_age" required=""/></div>
                
                    <div class="titles">Relationship with Applicant</div>
                    <div class="inputs"><input type="text" name="relationship" required=""/></div>
                
                    <div class="titles">Photo</div>
                    <div class="inputs"><input type="file" name="photo"/></div>
                
                    <div class="titles">Signature of the Applicant</div>
                    <div class="inputs"><input type="file" name="signature"/></div>

                <div class="btn">
                    <input type="submit" name="add_member" value="Add Membership" class="botn" />
                </div>
            </div>
        </form>
    </body>
</html>