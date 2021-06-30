<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Dev\Debug;

class ArticlePageController extends PageController
{
    private static $allowed_actions = [
        "CommentForm"
    ];

    public function CommentForm()
    {
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create("Name", ""),
                EmailField::create("Email", ""),
                TextareaField::create("Comment", ""),
            ),
            FieldList::create(
                FormAction::create("handleComment", "Post Comment")
                    ->setUseButtonTag(true)
                    ->addExtraClass("btn btn-default-color btn-lg"),
            ),
            RequiredFields::create("Name", "Email", "Comment")
        )
            ->addExtraClass("form-style");

        foreach ($form->Fields() as $field) {
            $field
                ->setAttribute("placeholder", "{$field->getName()}*")
                ->addExtraClass("form-control");
        }

        $CommentSessionState = $this->getRequest()->getSession()->get("FormData.{$form->getName()}.data");

        return $CommentSessionState ? $form->loadDataFrom($CommentSessionState) : $form;
    }

    public function handleComment($data, $form)
    {
        $session = $this->getRequest()->getSession();

        $session->set("FormData.{$form->getName()}.data", $data);

        $filtered = $this->Comments()->filter([
            "Comment" => $data["Comment"]
        ]);

        if ($filtered->exists()) {
            $form->sessionMessage("That comment already exists!", "bad");

            return $this->redirectBack();
        }


        if (strlen($data["Comment"]) <= 5) {
            $form->sessionMessage("Comments must be longer than 5 characters!", "bad");

            return $this->redirectBack();
        }

        $comment = ArticleComment::create();

        $form->saveInto($comment);

        $comment->ArticlePageID = $this->ID;
        $comment->write();

        $session->clear("FormData.{$form->getName()}.data");

        $form->sessionMessage("Thanks for your comment!", "good");

        return $this->redirectBack();
    }
}
