<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerYt4DQAO\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerYt4DQAO/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerYt4DQAO.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerYt4DQAO\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerYt4DQAO\App_KernelDevDebugContainer([
    'container.build_hash' => 'Yt4DQAO',
    'container.build_id' => '527ad94a',
    'container.build_time' => 1706719041,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerYt4DQAO');
