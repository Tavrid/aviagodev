Example router name {bundle name(admin|pay|.+)}_{route_name};
Example  service name {bundle name(admin|pay|.+)}.{service_name};

===============EXAMPLE NEW UPLOADER SERVICE=*yml*=================
uploader.service.container :
        class : 'Acme\MediaBundle\Model\SerivceContainer'
        arguments:
          - services :
              project : admin.project.uploader

    admin.project.uploader :
          class: %media.model.upload.class%
          arguments:
              - "@service_container"
              - params:
                    targetEntity : Acme\AdminBundle\Entity\Project
                    type : 'project'
                    entity: "%media.upload.entity.class%"
                    path: "%kernel.root_dir%/../web/files"
                    url: "acme_media_image"
                    count: 20
                    min_dimension : 100_100
                    dimensions :
                      resize : [ 800_600, 50_50]
                      crop : [234_180,165_165]
====================END===========================================