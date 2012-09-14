desc 'Prepare for new version'
task :prepare do
  system "rm -rf app lib skin"
end

desc 'Clean up permissions'
task :permissions do
  types = {
    d: 755,
    f: 644,
  }
  types.each_pair do |k,v|
    system "find . -type #{k} -print0 | xargs -0 chmod #{v}"
  end
end

task default: [ :permissions ]
