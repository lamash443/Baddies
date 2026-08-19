const fs = require('fs');
const path = 'resources/views/welcome.blade.php';
let content = fs.readFileSync(path, 'utf8');

const regex = /<style>@charset "UTF-8";\/\*![\s\S]*?\/\/# sourceMappingURL=bootstrap.min.css.map \*\/<\/style>/;

if(regex.test(content)) {
    const replacement = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">';
    content = content.replace(regex, replacement);
    fs.writeFileSync(path, content, 'utf8');
    console.log('Successfully replaced inline Bootstrap CSS.');
} else {
    console.log('Could not find the target style tags.');
}
