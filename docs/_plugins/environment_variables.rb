# Plugin to manage environment-specific variables in Liquid templates
module Jekyll
  class EnvironmentVariableTag < Liquid::Tag
    def initialize(tag_name, input, tokens)
      super
      @input = input.strip
    end

    def render(context)
      site = context.registers[:site]
      page = context.registers[:page]

      # Get the current environment
      current_env = page['environment'] || site.config['default_environment']

      # Find the environment configuration
      env_config = site.config['environments'].find { |env| env['name'] == current_env }

      # Return the URL if found, otherwise return a placeholder
      env_config ? env_config['url'] : "[Environment URL not found]"
    end
  end
end

Liquid::Template.register_tag('env_url', Jekyll::EnvironmentVariableTag)
