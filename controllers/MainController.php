<?php

namespace app\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\Controller;

class MainController extends Controller {

    /*public function beforeAction($action, $invalidate = null) {
        if (parent::beforeAction($action)) {
            //Authorization Logic
            #Get the current route
            $route = "/" . $this->getRoute();
            #Add $route to checking conditions
            if ($invalidate == null):
                if (!\Yii::$app->user->can($route)) {
                    $issue = new \app\models\Issue();
                    $issue->user_id = \Yii::$app->user->id;
                    $issue->action = $route;
                    $issue->viewed = \app\models\Issue::NOT_VIEWED;
                    $issue->description = \app\models\Issue::ERROR_ACCESS_DINED;
                    $issue->save();
                    throw new \yii\web\ForbiddenHttpException("Sorry, you don't have access to this page, Contact System Administrator");
                }

            endif;
            return true;
        }
        return false;
    }*/

    public function getActions() {
        //Array to store all the available controllers
        $controllers = [];
        //Array to store actions of every controller in $controllers
        $actions = [];
        //Accessing the controller folder
        if ($dir_handle = opendir('../controllers')) {
//Iterate in the directory and store all controller files
            while (false !== ($file = readdir($dir_handle))) {
                $check_condition = $file !== "." && $file !== ".." && substr($file, strrpos($file, ".") - 10) == "Controller.php";
                if ($check_condition) {
                    array_push($controllers, $file);
                }
            }
            closedir($dir_handle);
        }
        asort($controllers);
//Read controller files to get the actions
        foreach ($controllers as $controller) {
            $file_handle = fopen('../controllers/' . $controller, 'r');
            if ($file_handle) {
                while (($line = fgets($file_handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):

                            $word_array = str_split($display[1]);
                            $new_word_array = [];
                            foreach ($word_array as $character) {
                                if (ctype_upper($character)):
                                    $character = '-' . $character;
                                    array_push($new_word_array, $character);
                                else :
                                    array_push($new_word_array, $character);
                                endif;
                            }
                            $new_word_array[0] = str_replace('-', '', $new_word_array[0]);
                            $display[1] = implode('', $new_word_array);
                            $actions[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($file_handle);
        }
        //stores the refined routes
        $routes = [];
        //index of route
        $id = 1;
        foreach ($actions as $key => $value) {
            foreach ($value as $key1 => $value) {
                $route = '/' . strtolower(str_replace('Controller', '', $key)) . '/' . $value;
                $routes[$id++] = $route;
            }
        }

        return $routes;
    }

    //Adds routes to the action table (this is called one or when table is truncated)
    public function actionSaveRoutes() {
        foreach ($this->getActions() as $id => $route) {
            $model = new \app\models\Action();
            $model->route = $route;
            $model->save();
        }
    }

    //Adds other new routes to the action table
    public function actionSaveNewRoutes() {
        //Save New Routes
        foreach ($this->getActions() as $id => $route) {
            $model = \app\models\Action::findOne(['route' => $route]);
            if ($model == null) {
                $model = new \app\models\Action();
            }
            $model->route = $route;
            $model->save();
        }
        //Remove Actions that are in database but not in Controllers
        $controller_actions = $this->getActions();
        $db_actions = \app\models\Action::find()->all();
        foreach ($db_actions as $db_action):
            if (!in_array($db_action->route, $controller_actions)):
                $db_action->delete();
            endif;
        endforeach;
        //Done
        //Return success message
        \Yii::$app->getSession()->setFlash('message_updated', 'All the routes have been fully loaded!');
        return $this->redirect(['/role/index']);
    }

    //Adds Access Permissions to a role
    public function actionSavePermissions($role, $str_checked = null, $str_unchecked = null) {
        //Look for actions that are not assigned to the $role and delete them
        if (!empty($str_unchecked)):
            //Get an array of action ids for unchecked actions
            $unchecked_actions = explode(',', $str_unchecked);
            //Remove last element since it is ','
            array_pop($unchecked_actions);
            //Iterate through an array of action ids
            foreach ($unchecked_actions as $action_unchecked):
                //Get all models associated with unchecked actions
                $models = \app\models\CanPerform::find()->where(['role' => $role, 'action' => $action_unchecked])->all();
                //Check if models exist
                if (!empty($models)):
                    //Iterate in array of models
                    foreach ($models as $model) {
                        //Delete this $model
                        if (!empty($model) && $model->delete() != false) {
                            //Send a Flash Message
                            $this->sendFlashMessage($role);
                        } else {
                            //Deletion Failed or $model is null
                        }
                    }
                else:
                //$models is an empty array
                //To Do (Issue a Logic) ...
                endif;
            endforeach;
        //Close the loop
        endif;
        /*         * Done with Unchecked actions* */

        /*         * Working on checked actions* */
        #Check if the parameter $str_checked in non-empty
        if (!empty($str_checked)):
            #Get array of all checked actions
            $checked_actions = explode(',', $str_checked);
            #Remove last element of array as it is ','
            array_pop($checked_actions);
            #Iterate through an array of actions ids
            foreach ($checked_actions as $action_checked):
                #Check if individual action is non empty
                if (!empty($action_checked)):
                    #Find a model associated with role and $action_checked
                    $model = \app\models\CanPerform::findOne(['role' => $role, 'action' => $action_checked]);
                    #Check if model is not an existing record
                    if ($model == null) {
                        #Create a new model
                        $model = new \app\models\CanPerform();
                        #Assign $role to the role attribute
                        $model->role = $role;
                        #Assign $action_checked to the action attribute
                        $model->action = $action_checked;
                        #Check if the record has been created
                        if ($model->save()) {
                            //Send Flash message
                            $this->sendFlashMessage($role);
                        } else {
                            #Record isn't creted
                            #Supply a logic ...
                            $this->sendFlashMessage($role);
                        }
                    } else {
                        #Record exists,
                        #Simply do nothing
                        #Or
                        #Add a logic ...
                    }
                    #Send Flash message, once and for all
                    $this->sendFlashMessage($role);
                else:
                #$checked action is empty
                #Simply do nothing
                #Or
                #Add a logic ...
                endif;
                #Done Iterating within $checked_actions
            endforeach;
        else:
        #$checked_actions is empty, Do nothing ...
        #Or Do nothing ...
        endif;
        #Move back to Roles list ...
        //return $this->redirect(['/role/index']);
        #Update auth_tables as well
        return $this->redirect(['reload-granted-access']);
    }

    //Called to Create a session for a Flash Message @param $role is role id
    function sendFlashMessage($role) {
        //Message to send
        $message = 'Persmissions for ' . \app\models\Role::findOne($role)->role_desc . ' have been successfully updated!';
        //Create Session and Save a flash message
        \Yii::$app->getSession()->setFlash('message_updated', $message);
    }

    //Finds If permission exists
    //@param $role is role_id @param $str_actions is sequence of action ids
    public function actionFindPermission($role, $str_actions) {
        //Get array of action ids
        $actions = explode(',', $str_actions);
        //Create a string $response to store sequence of action ids
        $response = '';
        //Iterate in each action id
        foreach ($actions as $action):
            //Check if action id is existing
            if (!empty($action)):
                //Find model from table `can_perform` associated with $role and $action
                $model = \app\models\CanPerform::find()->where(['role' => $role, 'action' => $action])->one();
                //Check If $model is existing
                if ($model != null):
                    //Append value 'checked' to $response
                    $response = $response . 'checked' . ',';
                else:
                    //Append value null to response
                    $response = $response . 'null' . ',';
                endif;
            else:
            //$action isn't existing
            //There is nothing to do ...

            endif;
        endforeach;
        //Return sequence of checked values as string
        return $response;
    }

    #Finds data from tables {`role`,`action`, `can_perform`}
    #The found data is then distributed to user RBAC tables
    #These are {`auth_item`,`auth_item_child`,`auth_rule`,`auth_assignment`}
    #All these model classes are under the namespace \app\models\auth
    #Takes no parameter
    #Returns reponse message (Flash Message) and redirects to /role/index

    public function actionReloadGrantedAccess() {

        #Clean auth_tables first
        if ($this->cleanAuthData()):
            $this->beforeAction('/' . $this->getRoute(), true);
        endif;
        #Working on `auth_item`
        #Available Fields
        /**
         * @name --> role(role_name) or action(route) 
         * @description 
         * @type --> (1 for role and 2 for route)
         * @role_code --> (role(role_code) for role and 0 for route)
         * @rule_name --> auth_rule(name)
         * @data
         * @created_at
         * @updated_at
         */
        #Find roles
        $roles = \app\models\Role::find()->all();
        #Find actions
        $actions = \app\models\Action::find()->all();
        ###Populate `auth_item` with roles
        # @var update_count, counts number of updated records
        $update_count = 0;
        foreach ($roles as $role):
            #Find auth_item associated with $role->role_name
            $auth_item = \app\models\auth\AuthItem::findOne($role->role_name);
            #Check if $auth_item exists, do nothing else create new record
            if (!empty($auth_item)):
            //This record exists, do nothing ...
            else:
                //New record
                $auth_item = new \app\models\auth\AuthItem();
                #Add @name
                $auth_item->name = $role->role_name;
                #Add @description
                $auth_item->description = 'This is a role for ' . $role->role_desc;
                #Add @type
                $auth_item->type = 1;
                #Add @role_code
                $auth_item->role_code = $role->role_code;
                #Leave @rule_name to it's default value
                #Add @data
                $auth_item->data = 'This is a role for ' . $role->role_desc;
                #Add @created_at
                $auth_item->created_at = time();
                #Add @updated_at
                $auth_item->updated_at = time();
                #Save $auth_item and count it
                if ($auth_item->save()):
                    $update_count++;
                endif;
            endif;
        endforeach;
        ###Done with roles
        #
        #
        ###Populate `auth_item` with actions
        foreach ($actions as $action):
            #Find auth_item associated with $role->role_name
            $auth_item = \app\models\auth\AuthItem::findOne($action->route);
            #Check if $auth_item exists, do nothing else create new record
            if (!empty($auth_item)):
            //This record exists, do nothing ...
            else:
                //New record
                $auth_item = new \app\models\auth\AuthItem();
                #Add @name
                $auth_item->name = $action->route;
                #Add @description
                $auth_item->description = 'This is a rule';
                #Add @type
                $auth_item->type = 2;
                #Add @role_code
                $auth_item->role_code = 0;
                #Leave @rule_name to it's default value
                #Add data
                $auth_item->data = 'This is a rule ';
                #Add @created_at
                $auth_item->created_at = time();
                #Add @updated_at
                $auth_item->updated_at = time();
                #Save $auth_item and count it
                if ($auth_item->save()):
                    $update_count++;
                endif;
            endif;
        endforeach;
        ###Done with actions, Done with `auth_item`
        #
        #
        #Working on `auth_item_child`
        #Available fields
        /*

         * @parent --> auth_item(name)
         * @child --> auth_item(name)
         *          */
        /*         * *
         * admin is a parent for valuer, valuer_incharge, tra_officer
         * valuer and valuer_incharge are parents for tra_officer,
         * The hierarchy is defined by role($role_code) for roles and 0 
         * for normal routes
         * * */
        #Find parents
        $parents = \app\models\auth\AuthItem::find()->where(['>', 'role_code', 0])->all();
        #Find children
        $children = \app\models\auth\AuthItem::find()->where(['>', 'role_code', 1])->all();
        #Populate `auth_item_child`
        foreach ($parents as $parent):
            #Iterate through $children
            foreach ($children as $child):
                #Find auth_item_child associated with $parent and $child
                $auth_item_child = \app\models\auth\AuthItemChild::findOne(['parent' => $parent, 'child' => $child]);
                #Check if this record exist, then do nothing otherwise create a new one
                if (!empty($auth_item_child)):
                //Record exit, skip it ...
                else:
                    //Record does not exit, make it new and assign it attributes $parent and $child
                    $auth_item_child = new \app\models\auth\AuthItemChild();
                    #Add parent
                    $auth_item_child->parent = $parent->name;
                    #Add child
                    $auth_item_child->child = $child->name;
                    #Save the record and count int
                    if ($auth_item_child->save()):
                        $update_count++;
                    else:
                    //Something went wrong
                    //May issue, logic here ...
                    endif;
                endif;
            endforeach;
        endforeach;
        ###Done with auth_item_child
        #
        #
        ###Working on auth_rule
        #Available attributes
        /**
         * @name --> action(route)
         * @data --> left to default
         * @created_at --> set to current time tamp
         * @date_updated --> set to current time stamp
         * * */
        #Find all actions
        $actions1 = \app\models\Action::find()->all();
        #Iterate throungh $actions
        foreach ($actions1 as $action1):
            #Check if record with name $action1 exists do nothing otherwise make it new
            $rule = \app\models\auth\AuthRule::findOne($action1->action_id);
            if (!empty($rule)):
            //$rule exist, do nothing
            else:
                //$rule is not existing, create it
                $rule = new \app\models\auth\AuthRule();
                #Add name
                $rule->name = $action1->route;
                #Add created_at
                $rule->created_at = time();
                #Add updated_at
                $rule->updated_at = time();
                #Save this record and count int
                if ($rule->save()):
                    $update_count++;
                else:
                //Something went wrong, provide a solution logic
                endif;
            endif;
        endforeach;
        ###Done with auth_rule
        #
        #
        ###Working on auth_assignment.
        #Available attributes
        /**
         * @item_name --> auth_item(name)
         * @user_id --> user(user_id)
         * @created_at --> current time stamp
         * * */
        /*         * Start Other Logic* */
        #Find all permissions
        $permissions = \app\models\CanPerform::find()->all();
        #Iterate through $permissions
        foreach ($permissions as $permission):
            #Get route for $permission->action
            $action = \app\models\Action::findOne($permission->action)->route;
            #Find users associated with permissions
            $users = \app\models\User::find()->where(['role' => $permission->role])->all();
            #Iterate through users, look for auth_assignment associated with $permission->action and user_id
            foreach ($users as $user):
                #Find auth_assignment
                $auth_assignment = \app\models\auth\AuthAssignment::find()->where(['item_name' => $action, 'user_id' => $user->user_id])->one();
                #Check if $auth_assignment exists, do nothing else create it
                if (!empty($auth_assignment)):
                //Do nothing
                else:
                    //Add it as a new record
                    $auth_assignment = new \app\models\auth\AuthAssignment();
                    #Add item_name
                    $auth_assignment->item_name = $action;
                    #Add user_id
                    $auth_assignment->user_id = $user->user_id;
                    #Add created_at
                    $auth_assignment->created_at = time();
                    #Save this record and count it
                    if ($auth_assignment->save()):
                        $update_count++;
                    else:
                    //Something wrong happend
                    endif;
                endif;
            endforeach;

        endforeach;
        /*         * End Other Logic* */


        #Find all auth_items
        /* $auth_items = \app\models\auth\AuthItem::find()->all();
          #Check if $auth_items is empty, then do nothing
          if (empty($auth_items)):
          //Do nothing
          else:
          #Iterate through $auth_items
          foreach ($auth_items as $auth_item):
          #Store type, type --> role(role_code) use this to get role_id type must be greater than 0
          if ($auth_item->role_code > 0):
          $auth_item_type = $auth_item->role_code;
          #Find role using $auth_item_type
          $role = \app\models\Role::findOne(['role_code' => $auth_item_type]);
          #Find all users with role $role
          $users = \app\models\User::find()->where(['role' => $role->role_id])->all();
          #Iterate through $users
          foreach ($users as $user):
          #Check if there exist an auth_assignment for $auth_item->name and $user->user_id
          #If found make updates, if not found create it and assign values
          $auth_assignment = \app\models\auth\AuthAssignment::findOne(['item_name' => $auth_item->name, 'user_id' => $user->user_id]);
          #Check if this record exists
          if (!empty($auth_assignment)):
          //Record exist, leave it for now
          else:
          //Record does not exist, create it!
          $auth_assignment = new \app\models\auth\AuthAssignment();
          #Add item_name
          $auth_assignment->item_name = $auth_item->name;
          #Add user_id
          $auth_assignment->user_id = $user->user_id;
          #Add created_at
          $auth_assignment->created_at = time();
          #Save this record and count it
          if ($auth_assignment->save()):
          $update_count++;
          else:
          //Something wrong happend
          endif;
          endif;
          endforeach;
          else:
          #Find all actions, store them in $available_actions
          $available_actions = \app\models\Action::find()->all();
          #Iterate in $available_actions
          foreach ($available_actions as $available_action):
          #Find all permissions from the table can_perform that are associated with $available_action->action_id
          $persmissions = \app\models\CanPerform::find()->where(['action' => $available_action->action_id])->all();
          #Iterate in $persmission looking for role_id
          foreach ($persmissions as $persmission):
          #Find users associated with $permission->role_id
          $users = \app\models\User::find()->where(['role' => $persmission->role])->all();
          #Iterate in $users to read user_id
          foreach ($users as $user):
          #Get $auth_assignment associated with $auth_item and $user
          $auth_assignment = \app\models\auth\AuthAssignment::find()->where(['item_name' => $auth_item->name])->one();
          #Check if $auth_assignment is not a new record
          if (!empty($auth_assignment)):
          //Record exists, do nothing
          else:
          #Make $aut_assignment new record and assign values
          $auth_assignment = new \app\models\auth\AuthAssignment();
          #Add item_name
          $auth_assignment->item_name = $auth_item->name;
          #Add user_id
          $auth_assignment->user_id = $user->user_id;
          #Add created_at
          $auth_assignment->created_at = time();
          #Save the record and count it
          if ($auth_assignment->save()):
          $update_count++;
          else:
          //Something went wrong
          //Supply Validation Logic
          endif;
          endif;
          endforeach;
          endforeach;
          endforeach;
          //continue;
          endif;
          endforeach;
          endif; */
        ###Done Granting Access
        #
        ###Prepare Response message and Redirect to /role/index
        $message = $update_count . ' ' . 'Records have been successfully updated!';
        #Add message to Sessions
        \Yii::$app->getSession()->setFlash('message_updated', $message);
        #Redirect to /role/index
        return $this->redirect(['/role/index']);
    }

    /**
     * Called to clean all auth_tables before adding new values
     * Takes no @params, It returns true on success otherwise false,
     * Works on tables: auth_item, auth_item_child,auth_assignment and auth_rule
     * * */
    public function cleanAuthData() {
        # @var feedback is booolean value returned, it's set to true as default
        $feeback = true;
        ### auth_item
        $auth_items = \app\models\auth\AuthItem::find()->all();
        #Delete every auth_item in auth_items
        foreach ($auth_items as $auth_item):
            if ($auth_item->delete() == false):
                //Some records could not be deleted, set feedback to false
                $feeback = false;
            endif;
        endforeach;
        ### Done on auth_item
        #
        ### auth_item_child
        $auth_item_children = \app\models\auth\AuthItemChild::find()->all();
        #Delete every auth_item_child in auth_item_children
        foreach ($auth_item_children as $auth_item_child):
            if ($auth_item_child->delete() == false):
                //Some records could not be deleted, set feedback to false
                $feeback = false;
            endif;
        endforeach;
        ### Done on auth_item_child
        #
        ### auth_rule
        $auth_rules = \app\models\auth\AuthRule::find()->all();
        #Delete every auth_rule in auth_rules
        foreach ($auth_rules as $auth_rule):
            if ($auth_rule->delete() == false):
                //Some records could not be deleted, set feedback to false
                $feeback = false;
            endif;
        endforeach;
        ### Done on auth_rule
        #
        ### auth_assignment
        /* $auth_assignments = \app\models\auth\AuthAssignment::find()->all();
          #Delete every auth_assignment in auth_assignments
          foreach ($auth_assignments as $auth_assignment):
          if ($auth_assignment->delete() == false):
          //Some records could not be deleted, set feedback to false
          $feeback = false;
          endif;
          endforeach; */
        ### Done on auth_assignment
        #
        #
        #
        #### Done Cleaning auth_tables;
        return $feeback;
    }

}
