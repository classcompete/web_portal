<?php
$config = array(
    'parent.login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    ),
    'parent.signin.facebook' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim|valid_email'
        ),
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => 'required'
        )
    ),
    'parent.signin.google' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim|valid_email'
        ),
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'code',
            'label' => 'Code',
            'rules' => 'required'
        )
    ),
    'parent.registration' => array(
        /*array(
            'field' => 'country',
            'label' => 'Country',
            'rules' => 'required|trim'
        ),*/
        /*array(
            'field' => 'postalCode',
            'label' => 'Postal Code',
            'rules' => 'trim|required'
        ),*/
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        ),
        /*array(
            'field' => 'retypePassword',
            'label' => 'Retype password',
            'rules' => 'trim|required|min_length[6]|matches[password]'
        )*/
    ),
    'parent.wp.registration' => array(
        array(
            'field' => 'country',
            'label' => 'Country',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'postalCode',
            'label' => 'Postal Code',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        ),
    ),
    'parent.edit-profile' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        )
    ),
    'parent.edit-profile-with-password' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'LastName',
            'label' => 'Last name',
            'rules' => 'trim|required|min_length[3]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'retypePassword',
            'label' => 'Retype password',
            'rules' => 'trim|required|min_length[6]|matches[password]'
        )
    ),
    'parent.add-new-student' => array(
        array(
            'field' => 'firstName',
            'label' => 'First name',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'lastName',
            'label' => 'Last name',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'birthday',
            'label' => 'Birthday',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'retypePassword',
            'label' => 'Retype password',
            'rules' => 'trim|required|min_length[6]|matches[password]'
        )
    ),
    'parent.add-student-connection' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        )
    ),
    'parent.send-comment' => array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'comment',
            'label' => 'Comment',
            'rules' => 'trim|required'
        )
    )
);