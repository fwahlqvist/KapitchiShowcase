<?php

namespace KapitchiIdentity\Service\Auth;

interface IdentityResolver {
    public function resolveAuthIdentity($id);
}