<?php

return [
    'system_user_id' => '1',
    'per_page' => '10',

    'status' => ['0', '1', '2'],
    'status_text' => ['Inactive', 'Active', 'Block'],

    'gs_video_limit' => '10',

    'max_promoted_allowed' => '5',
    'max_words_about_me' => '5',
    'about_me' => 'I am new here',

    'image' => [
        'dir_path' => '/storage/',
        'default_types' => 'gif|jpg|png|jpeg',
        'default_img' => '/storage/images/default.png',
        'height' => '100',
        'width' => '100',
    ],

    'users' => [
        'gender' => ['0', '1'],
        'gender_text' => ['Male', 'Female'],

        'user_type' => ['0', '1', '2', '3', '4'],
        'user_type_text' => ['Admin', 'Entrant', 'Garba Jockey', 'Garba Class', 'Event'],

        'is_email_verified' => ['0', '1'],
        'is_email_verified_text' => ['No', 'Yes'],

        'is_mobile_verified' => ['0', '1'],
        'is_mobile_verified_text' => ['No', 'Yes'],

        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],

        'divice_type' => ['0', '1', '2'],
        'divice_type_text' => ['PC / Laptop', 'Android', 'IOS'],

        'provider_type' => ['0', '1', '2'],
        'provider_type_text' => ['Default', 'Facebook', 'Google'],

        'is_report' => ['0', '1'],
        'is_report_text' => ['No', 'Yes'],
    ],

    'follows' => [
        'action_type' => ['0', '1', '2'],
        'action_type_text' => ['Pending', 'Accepted', 'Rejected'],

        'follows_flag' => ['0', '1', '2', '3', '4'],
        'follows_flag_text' => ['Follow', 'Unfollow', 'Remove', 'Requested', 'Accept / Reject'],
    ],

    'posts' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],

        'is_hide' => ['0', '1'],
        'is_hide_text' => ['No', 'Yes'],

        'is_negative' => ['0', '1'],
        'is_negative_text' => ['No', 'Yes'],

        'is_report' => ['0', '1'],
        'is_report_text' => ['No', 'Yes'],
    ],

    'videos' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],
    ],

    'comments' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],
    ],

    'garba_classes' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked']
    ],

    'garba_class_videos' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],
    ],

    'awards' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],
    ],

    'documents' => [
        'doc_proof_type' => ['0', '1', '2'],
        'doc_proof_type_text' => ['Establishment Certificate', 'GST', 'Rant Agreement'],

        'is_varified_doc_proof' => ['0', '1', '2'],
        'is_varified_doc_proof_text' => ['Pending', 'Accepted', 'Rejected'],

        'is_varified_bank_detail' => ['0', '1', '2'],
        'is_varified_bank_detail_text' => ['Pending', 'Accepted', 'Rejected'],

        'id_proof_type' => ['0', '1', '2', '3'],
        'id_proof_type_text' => ['Aadhar Card', 'Voter ID Card', 'Driving Licence', 'Passport'],

        'is_varified_id_proof' => ['0', '1', '2'],
        'is_varified_id_proof_text' => ['Pending', 'Accepted', 'Rejected'],

        'is_varified_pan_card' => ['0', '1', '2'],
        'is_varified_pan_card_text' => ['Pending', 'Accepted', 'Rejected'],
    ],

    'subscriptions' => [
        'is_expired' => ['0', '1'],
        'is_expired_text' => ['No', 'Yes'],

        'status' => ['0', '1'],
        'status_text' => ['Inactive', 'Active'],

        'subscription_type' => ['0', '1'],
        'subscription_type_text' => ['Online', 'Offline'],
    ],

    'ratings' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],

        'points' => ['1' => '1', '2', '3', '4', '5'],
        'points_text' => ['1' => 'Very Bad', 'Bad', 'Good', 'Very Good', 'Excellent'],
    ],

    'pages' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],
    ],

    'events' => [
        'status' => ['0', '1', '2'],
        'status_text' => ['Inactive', 'Active', 'Blocked'],

        'type' => ['0', '1'],
        'type_text' => ['Image', 'Video'],

        'is_promoted' => ['0', '1'],
        'is_promoted_text' => ['No', 'Yes'],

        'is_sold_out' => ['0', '1'],
        'is_sold_out_text' => ['No', 'Yes'],
    ],

    'bookings' => [
        'status' => ['0', '1', '2', '3', '4'],
        'status_text' => ['Pending', 'Confirmed', 'Canceled', 'Failed', 'Reverted'],
    ],

    'event_documents' => [
        'is_varified_organization_id_proof' => ['0', '1'],
        'is_varified_organization_id_proof_text' => ['No', 'Yes'],

        'is_varified_event_address_proof' => ['0', '1'],
        'is_varified_event_address_proof_text' => ['No', 'Yes'],

        'is_varified_bank_detail' => ['0', '1'],
        'is_varified_bank_detail_text' => ['No', 'Yes'],
    ],

    'medias' => [
        'type' => ['0', '1'],
        'type_text' => ['Image', 'Video'],
    ],

    'permissions' => [
        'user_has_not_permission' => 'You don\'t have permission to access.'
    ],

    'validation_codes' => [
        'unauthorized' => "401",
        'forbidden' => "403",
        'not_found' => "404",
        'content_not_found' => "206",
        'not_verified' => "405",
        'unprocessable_entity' => "422",
        'created' => "201",
        'ok' => "200",
    ],

    'messages' => [
        'success' => [
            'login_success' => 'You are logged in successfully.',
            'logout_success' => 'You are logged out successfully.',
            'email_already'=>'Email is Already Exists.',
            'email_varify_success' => 'Email is Already Exists',
            'mobile_varify_success' => 'Mobile is varified successfully.',
            'document_varify_success' => 'Document(s) varified successfully.',
            'email_otp_resend_success' => 'Otp resend to your email successfully.',
            'mobile_otp_resend_success' => 'Otp resend to yout mobile successfully.',
            'password_changed_success' => 'Password is changes successfully.',
            'forgot_password_success' => 'Password reset link been sent to your email. Please check your inbox/spam.',
            'password_reset_success' => 'Your password has been reset successfully.',
            'follow_success' => 'Follow successfully, Please wait untill user accept.',
            'unfollow_success' => 'Unfollow successfully, You are not longer to reach to user.',
            'block_success' => 'Blocked successfully.',
            'unblock_success' => 'Unblocked successfully.',
            'subscribe_success' => 'Subscribed successfully.',
            'unsubscribe_success' => 'Unsubscribed successfully.',
            'follow_action_accept' => 'Follow request has been accepted.',
            'follow_action_reject' => 'Follow request has been rejected / removed.',
            'liked' => 'You liked this post.',
            'disliked' => 'You disliked this post.',
            'shared_success' => 'Post shared successfully.',
            'mark_as_read' => 'Notification(s) marked as read.',
            'notification_delete' => 'Notification(s) deleted.',
            'enrollment_success' => 'Your request for enroll to graba class has been success.',
            'payment_cancel' => 'Your payment got cancel. Please try again',
            'promoted_success' => 'Garba Class(es) has been promoted successfully.',
            'listed_success' => 'Record(s) has been listed successfully.',
            'showed_success' => 'Record has been shown successfully.',
            'stored_success' => 'Record has been stored successfully.',
            'deleted_success' => 'Record(s) has been deleted successfully.',
            'updated_success' => 'Record has been updated successfully.',
            'saved_success' => 'Record has been saved successfully.',
            'confirmed_success' => 'Record has been updated successfully.',
            'mark_negative_success' => 'Marked as negative successfully.',
            'unmark_negative_success' => 'Unmarked as negative successfully.',
            'hide_success' => 'Hide successfully.',
            'unhide_success' => 'Unhide successfully.',
            'report_success' => 'You have reported successfully.',
            'remove_report_success' => 'You have removed reported successfully.',
            'event_promoted_success' => 'You have promoted successfully.',
            'notify_success' => 'Notify to user successfully.',
        ],

        'errors' => [
            'otp_invalid'=>'Your Otp Is Invalid',
            'token_not_found' => 'Authorization Token not found',
            'invalid_token' => 'Your token is invalid / expired, Please reset again',
            'not_found' => 'No route / path / url available.',
            'content_not_found' => 'No content available.',
            'already_exists' => 'Record(s) is already exists.',
            'something_wrong' => 'Something went wrong.',
            'old_pwd_invalid' => 'The Old password is incorrect.',
            'change_password' => [
                'invalid_old_password' => 'Invalid old password.'
            ],
            'media_limit_out' => 'You can\'t upload more than 10 videos',
            'login' => [
                'invalid' => 'User is Invalid.',
                'account_not_verified' => 'Account is not varified.',
                'invalid_password' => 'Password is invalid.',
                'email_not_varified' => 'User has not varified email.',
                'mobile_not_varified' => 'User has not varified mobile.',
                'unauthorized_access' => 'Unauthorized access.'
            ],
            'users' => [
                'system_user_delete' => 'The system user can\'t be deleted'
            ],
            'email_already_varified' => 'Email already varified.',
            'mobile_already_varified' => 'Mobile already varified.',
            'follow_already' => 'Follow already.',
            'unfollow_already' => 'Unfollow already.',
                'enrollment_error' => 'Otp for enrollment is not match.',
                'subscribe_already' => 'Subscribed already.',
            'no_keyword_to_search' => 'Enter keyword to search.',
            'can_not_hide_your_post' => 'You can\'t hide your post(s), You can disable it.',
            'can_not_negative_your_post' => 'You can\'t mark your post(s) as negative.',
            'can_not_report_user' => 'You can\'t report to this user',
            'can_not_report_post' => 'You can\'t report to this post',
            'reverted_update_deny' => 'Unable to process your request Booking is reverted.',
            'confirmed_update_deny' => 'Unable to process your request Booking is confirmed.'
        ]
    ]
];
