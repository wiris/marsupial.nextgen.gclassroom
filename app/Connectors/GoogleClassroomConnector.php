<?php

namespace App\Connectors;

use App\Models\Lineitem;
use App\Models\Material;
use App\Models\User;
use Exception;
use Throwable;

class GoogleClassroomConnector extends GoogleAuthConnector
{

    public function __construct()
    {
    }

    public function share(User $user, Material $material)
    {

        $link = new \Google\Service\Classroom\Link();
        $link->setTitle($material->title);
        $link->setUrl($this->getShareableUrl($material->id));

        $gcMaterial = new \Google\Service\Classroom\Material();
        $gcMaterial->setLink($link);

        $courseId = $material->course_id;

        if ($material->gradable) {
            $coursework = new \Google\Service\Classroom\CourseWork();
            $coursework->setTitle($material->title);
            $coursework->setDescription($material->description);
            $coursework->setMaxPoints($material->score_maximum);
            $coursework->setWorkType('ASSIGNMENT');
            $coursework->setMaterials([$gcMaterial]);
            return $this->getService($user)->courses_courseWork->create($courseId, $coursework)->getId();
        } else {
            $courseworkMaterial = new \Google\Service\Classroom\CourseWorkMaterial();
            $courseworkMaterial->setTitle($material->title);
            $courseworkMaterial->setDescription($material->description);
            $courseworkMaterial->setMaterials([$gcMaterial]);
            return $this->getService($user)->courses_courseWorkMaterials->create($courseId, $courseworkMaterial)->getId();
        }
    }

    public function putGrade(Lineitem $lineitem)
    {
        $attemptingUser = $lineitem->user;
        $material = $lineitem->material;

        $courseId = $material->course_id;
        $courseworkId = $material->coursework_id;

        $studentService = $this->getService($attemptingUser);
        $studentSubmissions = $studentService->courses_courseWork_studentSubmissions->listCoursesCourseWorkStudentSubmissions($courseId, $courseworkId)->getStudentSubmissions();

        $teacher = $material->user;
        $teacherService = $this->getService($teacher);

        foreach ($studentSubmissions as $studentSubmission) {
            /*
            $link = new \Google\Service\Classroom\Link();
            $link->setUrl($this->getShareableUrl($material->id, $material->id));

            $attachment = new \Google\Service\Classroom\Attachment();
            $attachment->setLink($link);

            $attachments = new \Google\Service\Classroom\ModifyAttachmentsRequest();
            $attachments->setAddAttachments([$attachment]);
            $studentService->courses_courseWork_studentSubmissions->modifyAttachments(
                $courseId,
                $courseworkId,
                $studentSubmission->getId(),
                $attachments
            );
            */

            $studentService->courses_courseWork_studentSubmissions->turnIn($courseId, $courseworkId, $studentSubmission->getId(), new \Google\Service\Classroom\TurnInStudentSubmissionRequest());

            $grade = $material->score_maximum * $lineitem->score_given / $lineitem->score_maximum;

            $studentSubmission->setDraftGrade($grade);
            $studentSubmission->setAssignedGrade($grade);
            $teacherService->courses_courseWork_studentSubmissions->patch(
                $courseId,
                $courseworkId,
                $studentSubmission->getId(),
                $studentSubmission,
                [
                    "updateMask" => "draftGrade,assignedGrade"
                ]
            );

            $teacherService->courses_courseWork_studentSubmissions->returnCoursesCourseWorkStudentSubmissions($courseId, $courseworkId, $studentSubmission->getId(), new \Google\Service\Classroom\ReturnStudentSubmissionRequest());
        }
    }

    private function getShareableUrl(string $materialId)
    {
        return route('materials.show', ['material' => $materialId]);
    }

    public function validateAssignmentOpen(User $user, Material $material)
    {
        $courseId = $material->course_id;
        $courseworkId = $material->coursework_id;

        $service = $this->getService($user);

        try {
            $assignment = $service->courses_courseWork->get($courseId, $courseworkId);

            // TODO: check due date and due time have not passed.
            return $assignment->getState() == 'PUBLISHED';
        } catch (Throwable $t) {
            return false;
        }
    }

    public function isVerifiedTeacher(User $user)
    {
        return $this->getService($user)->userProfiles->get('me')->getVerifiedTeacher();
    }

    public function getCourseName(User $user, string $courseId)
    {
        return $this->getService($user)->courses->get($courseId)->getName();
    }

    public function getCourses(User $user, bool $asTeacher)
    {
        $service = $this->getService($user);


        /**
         * Retrieve courses paginated (100/req)
         */
        $courses = [];
        $pageToken = null;

        $params = [
            'pageSize' => 100,
            'pageToken' => $pageToken,
            'courseStates' => ['ACTIVE', 'PROVISIONED']
        ];

        if ($asTeacher) {
            $params['teacherId'] = 'me';
        } else {
            $params['studentId'] = 'me';
        }

        do {
            $res = $service->courses->listCourses($params);
            if ($res->courses) {
                $courses += $res->courses;
                $pageToken = $res->nextPageToken;
            }
        } while (!empty($pageToken));


        return $courses;
    }

    private function getService(User $user): \Google\Service\Classroom
    {
        /**
         * Get google api client for session user
         */
        $client = $this->getAuthorizedClient($user);

        /**
         * Create a service using the client
         */
        $service = new \Google\Service\Classroom($client);
        return $service;
    }

    public function isMemberOfCourse(User $user, string $courseId): bool
    {
        return $this->isStudentOfCourse($user, $courseId) || $this->isTeacherOfCourse($user, $courseId);
    }

    public function isTeacherOfCourse(User $user, string $courseId): bool
    {
        return $this->belongsToCourse($user, $courseId, true);
    }

    public function isStudentOfCourse(User $user, string $courseId): bool
    {
        return $this->belongsToCourse($user, $courseId, false);
    }

    private function belongsToCourse(User $user, string $courseId, bool $asTeacher): bool
    {
        $courses = $this->getCourses($user, $asTeacher);
        foreach ($courses as $course) {
            if ($course->getId() == $courseId) {
                return true;
            }
        }
        return false;
    }

    public function getCourseworkInformation(User $user, Material $material): array
    {
        $service = $this->getService($user);
        $course = null;
        $coursework = null;

        try {
            $course = $service->courses->get($material->course_id);
            $coursework = $service->courses_courseWork->get($material->course_id, $material->coursework_id);
        } catch (Exception $e) {
        }

        $data = [];
        if ($course) {
            $data['courseLink'] = $course->getAlternateLink();
            $data['courseName'] = $course->getName();
        }
        if ($coursework) {
            $data['link'] = $coursework->getAlternateLink();
        }

        $data['state'] = $coursework ? $coursework->getState() : 'NOT_FOUND';

        return $data;
    }

    public function deleteCourseWork(User $user, Material $material)
    {
        $service = $this->getService($user);

        try {
            $service->courses_courseWork->delete($material->course_id, $material->coursework_id);
        } catch (Exception $e) {
        }
    }
}
