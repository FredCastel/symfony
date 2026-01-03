<?php

namespace Core\Application\Message;

final class GlobalMessages implements MessagesCode
{
    /** {message} */
    const Text = "GlobalMessages.Text";
    /** {id} is not an Entity */
    const UnknownEntity = "GlobalMessages.UnknownEntity";
    /** {label} can not be removed */
    const UnremovableEntity = "GlobalMessages.UnremovableEntity";
    /** {label} is still used */
    const StillUsedEntity = "GlobalMessages.StillUsedEntity";
    /** {property} must not be empty */
    const NotEmptyProperty = "GlobalMessages.NotEmptyProperty";
    /** {property} must not be null */
    const NotNullProperty = "GlobalMessages.NotNullProperty";
    /** {property} must be a string */
    const NotStringProperty = "GlobalMessages.NotStringProperty";
    /** {property} must be set */
    const NotsetProperty = "GlobalMessages.NotsetProperty";
    /** {property} must not be changed */
    const UnchangebleProperty = "GlobalMessages.UnchangebleProperty";
    /** {property} ({value}) is not valid */
    const InvalidProperty = "GlobalMessages.InvalidProperty";

}