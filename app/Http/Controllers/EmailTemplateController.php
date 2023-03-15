<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->Model = new EmailTemplate;
    }

    /**
     * [create This function is create email template
     * @return [type] [description]
     */

    public function create()
    {
        $title = trans('message.email_template_title');
        return view('email_template.addedit', compact('title'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans('message.email_template_title');
        return view('email_template.index', compact('title'));
    }

    /**
     * [store used for register email template ]
     * @return [type] [description]
     */
    public function store(EmailTemplateRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [anyData used for get email template list through yajra ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

    /**
     * [edit used for edit email template data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $title = trans('message.email_template_edit');
        $id = getDecryptedId($id);
        $email_template = $this->Model->getSingleData($id);
        return view('email_template.addedit', compact('title', 'email_template', 'encryptedId'));
    }

    /**
     * [update used for update email template data ]
     * @return [type] [description]
     */
    public function update(EmailTemplateRequest $request, $id)
    {

        return $this->Model->store($request, $id);
    }

    /**
     * [SingleStatusChange This function is active inactive single record .]
     * @param Request $request [description]
     */
    public function singleStatusChange(Request $request)
    {

        return $this->Model->singleStatusChange($request);
    }

    /**
     * [statusAll This function is used to active or inactive specific selected email template record]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function statusAll(Request $request)
    {

        return $this->Model->statusAll($request);
    }

    /**
     * [statusAll This function is used to active or inactive specific selected email template record]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function preview(Request $request, $id)
    {

        $id = getDecryptedId($id);
        $emailTemplate = $this->Model->getSingleData($id);
        $email_body = trim($emailTemplate->description);
        return view("emails.mail_template", compact('email_body'));
    }

}
