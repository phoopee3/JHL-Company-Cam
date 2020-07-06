# Company Cam

## Use Case

Show a gallery of photos from the Company Cam site.

## Disclaimers/Warnings

## Installation

Download the zip and install it via the WordPress admin, or unzip/clone to the plugins folder, in a folder named `jhl-company-cam`

## Setup Instructions

Go to the plugins page and activate `Company Cam`.

Go to the `Settings` menu, and then `Company Cam`.

Enter the API key you created on the Company Cam site.

Enter the API url you want to use. Right now I'm only supporting the `API/projects` url, so you'll have to use that or else it won't work.

Enter the project ID that you want to access using the API key.

Enter the endpoint that you want to use. Right now I'm only supporting the `/projects/<ID>/photos` endpoint, so you have to enter `photos` or else it won't work.

Go to a page or a post where you want the photo gallery and use the shortcode `[company_cam]` to enable the shortcode.

## To do / Roadmap

- [ ] More endpoints
- [ ] Use transients
- [ ] Clear transients
- [ ] More shortcodes